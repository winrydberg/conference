<?php

namespace App\Http\Controllers;

use App\Exports\ConferenceAbstractExport;
use App\Exports\RegistrantsExport;
use App\Jobs\ProcessAbstractApproval;
use App\Models\Admin;
use App\Models\Application;
use App\Models\Conference;
use App\Models\ConferenceAbstract;
use App\Models\Document;
use App\Models\PaymentCategory;
use App\Models\PaymentMode;
use App\Models\Sponsor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use ZipArchive;
use Maatwebsite\Excel\Facades\Excel;

class AdminController extends Controller
{
    // private $staffURL = "#";
    public $staffURL = 'https://sts.ug.edu.gh/services/api/itse/ugmobile/authenticate/outh_staff_with_id?itse_key=iEhJVAFeWNoUKZSmfsRXBQfRUEM1k4ln52CvDrxu&itse_secret=cUJhEDGXfVb2iLWySmFPN9njiKwqJcs8Ag0F2ph4';

    public function login(){
        return view('admin.login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->to('/admin-login');
    }

    public function loginAdmin(Request $request){
        try{
            $admin = Admin::where('username', $request->username)->first();
            
            if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
                $request->session()->regenerate();
                return response()->json([
                    'status' => 'success',
                    'url' => url('/admin-dashboard'),
                    'message' => 'Login successful. Redirecting to admin dashboard'
                ]);
            } else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid Login Credentials'
                ]);
            }
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong. Unable to login. Contact Administrators'
            ]);
        }
    }


    public function index(){
        $admin = Auth::guard('admin')->user();
        $upcoming = [];
        $upcomingcount = 0;
        $concount = 0;
        if($admin->hasRole('UGCS-ADMIN')){
            $upcoming = Conference::withCount('registrants', 'abstracts')->where('startdate', '>=', date('Y-m-d'))->get();
            $upcomingcount = Conference::where('startdate', '>=', date('Y-m-d'))->count();
            $concount = Conference::count();
        }else{
            $permissions = $admin->getAllPermissions();

            // dd(count($permissions));
            
            foreach($permissions as $p){
                $conferences = Conference::withCount('registrants', 'abstracts')
                                            ->where('startdate', '>=', date('Y-m-d'))
                                            ->where('permission_tag', $p->name)->get();
                
                foreach($conferences as $c){
                    $concount += 1;
                    $upcomingcount += 1;
                    array_push($upcoming, $c);
                }
            }
        }
        return view('admin.index', compact('upcoming', 'concount', 'upcomingcount'));
    }

    public function newConference(){
        $paymodes = PaymentMode::all();
        return view('admin.newconference', compact('paymodes'));
    }

    public function saveNewConference(Request $request){

        $permission = null;
        $conference = null;
        try{
            $thedocs = [];
            $logos = [];
            if($request->hasFile('documents')){
                $documents = $request->file('documents');
                // $documents->getClientOriginalName()
                foreach($documents as $doc){
                    // $ext = $doc->getClientOriginalExtension();
                    $originalname = $doc->getClientOriginalName();
                    $docfilename = $originalname;
                    $doc->move(storage_path('app/public/attachments'), $docfilename);
                    array_push($thedocs, $docfilename);
                }
            }



            

            $brochure = '';
            $token  = sha1(time());
            $permtag = Str::slug($request->title);
            $conference = Conference::create([
                'image' => null,
                'title' => $request->title,
                'startdate' => $request->startdate,
                'enddate' => $request->enddate,
                'venue' => $request->venue,
                'starttime' => $request->starttime,
                'endtime' => $request->endtime,
                'description' => $request->description,
                'theme' => $request->theme,
                'regtable' => 'N/A',
                'extras' => '',
                'isopen' => $request->isopen == '1' ? true : false,
                'receive_abstract' => $request->receive_abstract == '1' ? true : false,
                'url' => url('/apply-now?cid='.$token),
                'token' => $token,
                'attachments' => json_encode($thedocs),
                'permission_tag' => $permtag,
                'brochure' => $brochure != ''? $brochure : null,
                'require_payment' => $request->require_payment,
                'payment_modes' =>json_encode($request->payment_methods),
                'bankinfo' => $request->accinfo,
                'reg_startdate' => $request->reg_startdate,
                'reg_enddate' => $request->reg_enddate,
                'benefits' => $request->benefits,
                'organizers' => $request->organizers
            ]);

            $permission = Permission::where('name', $permtag)->first();
            if($permission == null){
                $permission = Permission::create(['name' => $permtag, 'guard_name' => 'admin']);
            }
            

            $brochure = '';
            if($request->hasFile('brochure')){
                $doc = $request->file('brochure');
                $originalname = $doc->getClientOriginalName();
                $brochure = 'BROCHURE_'.time().'_'.$originalname;
                // $doc->move(storage_path('app/public/brochure/'), $brochure);
                $doc->move(storage_path('app/public/documents/'), $brochure);
                Document::create([
                    'type_name' => 'Conference Brochure',
                    'file' => $brochure,
                    'conference_id' => $conference?->id
                ]);

                $conference->update([
                    'brochure' => $brochure != ''? $brochure : null,
                ]);
            }

            if($request->hasFile('abstract_temp')){
                $doc = $request->file('abstract_temp');
                $originalname = $doc->getClientOriginalName();
                $abstract_temp = 'ABSTRACT_TEMPLLATE_'.time().'_'.$originalname;
                // $doc->move(storage_path('app/public/brochure/'), $brochure);
                $doc->move(storage_path('app/public/documents/'), $abstract_temp);
                Document::create([
                    'type_name' => 'Abstract Template',
                    'file' => $abstract_temp,
                    'conference_id' => $conference?->id
                ]);
            }



            if($request->hasFile('logo')){
                $thelogos = $request->file('logo');
                $sponsornames = $request->sponsorname;
                if(is_array($thelogos)){
                    foreach($thelogos as $key => $logo){
                        $originalname = $logo->getClientOriginalName();
                        $docfilename = $sponsornames[$key].'_'.$originalname;
                        $logo->move(storage_path('app/public/logos'), $docfilename);
                        Sponsor::create([
                            'name' => $sponsornames[$key],
                            'logo' => $docfilename,
                            'conference_id' => $conference?->id
                        ]);
                    }
                }
            }

            $admin = Auth::guard('admin')->user();
            $admin->givePermissionTo($permission);


            //payment categories
            $paycategory_names = $request->category;
            $paycategory_amount = $request->amount;
            $paycategory_currencies = $request->currency;

            if(is_array($paycategory_names)){
                for($i = 0 ;$i<count($paycategory_names); $i++){
                    PaymentCategory::create([
                        'name' => $paycategory_names[$i],
                        'currency' => $paycategory_currencies[$i],
                        'amount' => array_key_exists($i, $paycategory_amount) ? $paycategory_amount[$i]: '0.0',
                        'conference_id' => $conference?->id
                    ]);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Conference successfully created'
            ]);
        }catch(Exception $e){
            if($permission != null){
                $permission->delete();
            }

            if($conference != null){
                $conference->delete();
            }
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to register conference. Please try again'
            ]);
        }
        // return view('admin.newconference');
    }

    public function conferences(){
        
        $admin = Auth::guard('admin')->user();
        $conferences = [];
        if($admin->hasRole('UGCS-ADMIN')){
            $conferences = Conference::withCount('registrants', 'abstracts')->paginate(20);
        }else{
            $permissions = $admin->getAllPermissions();
            
            foreach($permissions as $p){
                $thecons = Conference::withCount('registrants', 'abstracts')
                                            ->where('permission_tag', $p->name)->get();
                foreach($thecons as $c){
                    array_push($conferences, $c);
                }
            }

            $conferences = collect($conferences);
        }
        return view('admin.conferences', compact('conferences'));
    }

    public function viewAbstract(Request $request){

        $confid = $request->query('conferenceid', null);
        //check id admin has permissions for conference;

        //get conference
        $conference = Conference::where('id', $confid)->first();
        if($conference == null){
            return back()->with('error', 'Conference not found');
        }
        //get abstratcts
        $abstracts = ConferenceAbstract::where('conference_id', $conference->id)->get();

        return view('admin.abstracts', compact('abstracts', 'conference'));
        
    }



    public function getRegistratnts(Request $request){
        $confid = $request->query('conferenceid', null);
        //check id admin has permissions for conference;

        //get conference
        $conference = Conference::where('id', $confid)->first();
        if($conference == null){
            return back()->with('error', 'Conference not found');
        }
        //get abstratcts
        $registrants = Application::where('conference_id', $conference->id)->get();

        return view('admin.registrants', compact('registrants', 'conference'));
    }



    public function accounts(){
        $users = Admin::all();
        $roles = Role::all();
        return view('admin.accounts', compact('users', 'roles'));
    }

    public function saveNewAdmin(Request $request){
        try{
            Log::info($request->all());
           
            $user = Admin::create([
                'username' => $request->authtype == 'staffid' ? $request->staff_id : $request->username,
                'email' => $request->authtype == 'staffid' ? $request->email : '',
                'password' => Hash::make($request->password)
            ]);

            $user->assignRole($request->role);

            return response()->json([
                'status' => 'success',
                'message' => 'User account successfully created'
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to add admin. Please try again'
            ]);
        }
    }


    public function deleteAdmin(Request $request){
        try{
            $admin = Admin::where('id', $request->id)->first();
            $admin->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Admin account successfully removed'
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to delete user account'
            ]);
        }
    }


    public function getStaffInfo(Request $request){
        try{
            //get staff data
            $response = Http::post($this->staffURL, [
                'staff_id' => $request->staff_id
            ]);
            $resObj = $response->object();
            Log::info($response);
            $staff_data = $resObj->data;
            return  response()->json([
                'status' => 'success',
                'staff' => $staff_data
            ]);
        }catch(Exception $e){
            Log::error('GET STAFF INFO ERROR => '.$e->getMessage());
            return response()->json([
                'status' => 'error',
            ]);
        }
    }

    public function editConference(Request $request){
        $confid = $request->query('conferenceid', null);

        $conference = Conference::where('id', $confid)->first();

        if($conference == null){
            return back()->with('error', 'Conference not found');
        }

        $paymodes = PaymentMode::all();
        $abstract = Document::where('file', 'like', '%ABSTRACT_TEMPLATE%')->where('conference_id', $conference->id)->orderBy('id', 'DESC')->first();
        return view('admin.editconference', compact('conference', 'paymodes', 'abstract'));
    }

    public function  saveEditedConference(Request $request){
        try{
            $thedocs = [];
            // if($request->hasFile('documents')){
            //     $documents = $request->file('documents');
            //     // $documents->getClientOriginalName()
            //     foreach($documents as $doc){
            //         // $ext = $doc->getClientOriginalExtension();
            //         $originalname = $doc->getClientOriginalName();
            //         $docfilename = $originalname;
            //         $doc->move(storage_path('app/attachments'), $docfilename);
            //         array_push($thedocs, $docfilename);
            //     }
            // }

            $conference = Conference::where('id', $request->id)->first();
            if($conference == null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Conference not found. Please refresh the pagee and try again'
                ]);
            }

            $conference->title = $request->title != null ? $request->title : $conference->title;
            $conference->startdate = $request->startdate == null ? $request->startdate : $conference->startdate;
            $conference->enddate = $request->enddate != null ? $request->enddate : $conference->enddate;
            $conference->venue = $request->venue != null ? $request->venue : $conference->venue;
            $conference->starttime  = $request->starttime != null ? $request->starttime : $conference->starttime;
            $conference->endtime = $request->endtime != null ? $request->endtime : $conference->endtime;
            $conference->description = $request->description != null ? $request->description : $conference->description;
            $conference->theme = $request->theme != null ? $request->theme : $conference->theme;
            $conference->regtable = 'N/A';
            

            $conference->isopen = $request->isopen !=  null ? $request->isopen : $conference->isopen;
            $conference->receive_abstract  = $request->receive_abstract != null ? $request->receive_abstract : $conference->receive_abstract;
            $attachments = json_decode($conference->attachments);

            $conference->require_payment = $request->require_payment != null ? $request->require_payment: $conference->require_payment;
            $conference->payment_modes = json_encode($request->payment_methods);
            $conference->bankinfo = $request->accinfo;
            $conference->reg_startdate = $request->reg_startdate;
            $conference->reg_enddate = $request->reg_enddate;
            $conference->benefits = $request->benefits;
            $conference->organizers = $request->organizers;
            // $conference->theme = $request->theme;

            // $conference->save();


            if(is_array($attachments) && count($thedocs) > 0){
                foreach($thedocs as $d){
                    array_push($attachments, $d);
                }
                $conference->attachments = json_encode($attachments);
            }

            $brochure = '';
            if($request->hasFile('brochure')){
                $doc = $request->file('brochure');
                $originalname = $doc->getClientOriginalName();
                $brochure = 'BROCHURE_'.time().'_'.$originalname;
               
                $doc->move(storage_path('app/public/documents/'), $brochure);

                $bch = Document::where('type_name', 'Conference Brochure')->where('conference_id', $conference->id)->first();
                if($bch == null){
                    Document::create([
                        'type_name' => 'Conference Brochure',
                        'file' => $brochure,
                        'conference_id' => $conference?->id
                    ]);
                }else{
                    $bch->update([
                        'file' => $brochure
                    ]);
                }
                $conference->update([
                    'brochure' => $brochure != ''? $brochure : null,
                ]);
            }

            //payment categories
            $paycategory_names = $request->category;
            $paycategory_amount = $request->amount;
            $paycategory_currencies = $request->currency;

            PaymentCategory::where('conference_id', $conference->id)->delete();

            if(is_array($paycategory_names)){
                for($i = 0 ;$i<count($paycategory_names); $i++){
                    PaymentCategory::create([
                        'name' => $paycategory_names[$i],
                        'currency' => $paycategory_currencies[$i],
                        'amount' => array_key_exists($i, $paycategory_amount) ? $paycategory_amount[$i]: '0.0',
                        'conference_id' => $conference?->id
                    ]);
                }
            }

            Sponsor::where('conference_id', $conference->id)->delete();
            if($request->hasFile('logo')){
                $thelogos = $request->file('logo');
                $sponsornames = $request->sponsorname;
                if(is_array($thelogos)){
                    foreach($thelogos as $key => $logo){
                        $originalname = $logo->getClientOriginalName();
                        $docfilename = $sponsornames[$key].'_'.$originalname;
                        $logo->move(storage_path('app/public/logos'), $docfilename);
                        Sponsor::create([
                            'name' => $sponsornames[$key],
                            'logo' => $docfilename,
                            'conference_id' => $conference?->id
                        ]);
                    }
                }
            }

            if($request->hasFile('abstract_temp')){
                $doc = $request->file('abstract_temp');
                $originalname = $doc->getClientOriginalName();
                $abstract_temp = 'ABSTRACT_TEMPLLATE_'.time().'_'.$originalname;
                // $doc->move(storage_path('app/public/brochure/'), $brochure);
                $doc->move(storage_path('app/public/documents/'), $abstract_temp);

                $abs = Document::where('type_name', 'Abstract Template')->where('conference_id', $conference->id)->first();
                if($abs == null){
                    Document::create([
                        'type_name' => 'Abstract Template',
                        'file' => $abstract_temp,
                        'conference_id' => $conference?->id
                    ]);
                }else{
                    $abs->update([
                        'file' => $abstract_temp
                    ]);
                }
                
            }
            $conference->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Conference successfully updated'
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to update conference. Please try again.'
            ]);
        }
    }


    public function deleteAttachment(Request $request){
        try{
           $conference = Conference::where('id', $request->id)->first();
           if($conference == null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'File not found'
                ]);
           } 

           $attachments = json_decode($conference->attachments);
           if(is_array($attachments)){
                $toremove = [$request->file];
                $result = array_diff($attachments, $toremove);
                $conference->update([
                    'attachments' => json_encode($result)
                ]);
           }

           return response()->json([
            'status' => 'success',
            'message' => 'File has been removed from conference attachments'
        ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to delete attachment. Please try again'
            ]);
        }
    }


    public function downloadAllAbstracts(Request $request){
        try{
            $conferenceid = $request->query('conferenceid', null);
            $conference = Conference::where('id', $conferenceid)->first();
            if($conference == null){
                return back()->with('error', 'Files not found');
            }

            $name = "ABSTRACT_FILES_".$conference->token.'_FILES.zip';
            $storePath = storage_path('app/downloads/'.$name);

            if (!File::exists(storage_path('app/public/downloads/'))) {
                File::makeDirectory(storage_path('app/public/downloads/'), 0755, true);
            }
                // Initialize archive object
            $zip = new ZipArchive();
            $zip->open($storePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
            $abstracts = ConferenceAbstract::where('conference_id', $conference->id)->get();
            foreach ($abstracts as $abs)
            {
                    $zip->addFile(storage_path().'/app/public/abstracts/'.$abs->document, $abs->document);
            }
            // Zip archive will be created only after closing object
            $zip->close();

            return response()->download($storePath);

        }catch(Exception $e){
            Log::error($e);
            return back();
        }
    }


    public function downloadAbstract(Request $request){
        try{
            $abstractid = $request->query('abstractid', null);
            $abstract = ConferenceAbstract::where('id', $abstractid)->first();
            if($abstract != null){
                return response()->download(storage_path().'/app/public/abstracts/'.$abstract->document);
            }else{
                return back()->with('error', 'Abstract File not found');
            }
        }catch(Exception $e){
            Log::error($e);
            return back();
        }
    }


    public function updateAbstractState(Request $request){
        try{
            $abstract = ConferenceAbstract::where('id', $request->abs_id)->first();
            if($abstract){
                $abstract->update([
                    'approved' => $request->state
                ]);

                $conference = Conference::where('id', $abstract->conference_id)->first();
                dispatch(new ProcessAbstractApproval($abstract, $conference, $request->state));
                
                $message = "";
                if($request->state == '1'){
                    $message = "Abstract successfully approved. An approval email has been sent to participant";
                }else{
                    $message = "Abstract successfully disapproved. A disapproval email has been sent to participant";
                }
                return response()->json([
                    'status' => 'success',
                    'message' => $message
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Oops, Aabstract not found. Please refresh the page & try again'
                ]); 
            }
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Oops, Unable to update abstract state. Please try again'
            ]);
        }
    }



    public function exportRegistrantsToExcel(Request $request){
        try{
            $confid = $request->query('conferenceid', null);
            $conference = Conference::where('id', $confid)->first();
            $name = "CONFERENCE_REGISTRANTS_".$conference?->token.".xlsx";
            return Excel::download(new RegistrantsExport($conference->id), $name);
        }catch(Exception $e){
            Log::error($e);
            return back()->with('error', 'Unable to export to excel. Please contact administrators');
        }
    }


    public function exportAbstractsToExcel(Request $request){
        try{
            $confid = $request->query('conferenceid', null);
            $conference = Conference::where('id', $confid)->first();
            $name = "CONFERENCE_ABSTRACTS_".$conference?->token.".xlsx";
            return Excel::download(new ConferenceAbstractExport($conference->id), $name);
        }catch(Exception $e){
            Log::error($e);
            return back()->with('error', 'Unable to export to excel. Please contact administrators');
        }
    }


    
    public function deleteConference(Request $request){
        try{
            $admin = Auth::guard('admin')->user();
            $conference = Conference::where('id', $request->id)->first();
            if($conference != null){
             
                if($admin->hasPermissionTo($conference->permission_tag) || $admin->hasRole('UGCS-ADMIN')){
                    $conference->delete();
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Conference successfully deleted'
                    ]);
                }else{
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You don not have the right permissions to delete conference'
                    ]);
                }
            }
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to delete conference.'
            ]);
        }
        
    }


    public function addDocument(Request $request){

        $conferenceid = $request->query('conferenceid', null);

        $conference = Conference::where('id', $conferenceid)->first();
        if($conference == null){
            return back();
        }

        $documents = Document::where('conference_id', $conference->id)->get();
        return view('admin.adddocuments', compact('conference', 'documents'));
    }


    public function saveDocuments(Request $request){
        try{
            if($request->hasFile('file')){
                $doc = $request->file('file');
                $originalname = $doc->getClientOriginalName();
                $fname = explode(" ", $request->doctype. " ");
                $docname = $fname[0].'_'.time().'_'.$originalname;
                $doc->move(storage_path('app/public/documents'), $docname);
                Document::create([
                    'type_name' => $request->doctype,
                    'file' => $docname,
                    'conference_id' => $request?->id
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Conference document successfully uploaded'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please select file to upload'
                ]);
            }
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to save document. Please try again'
            ]);
        }
    }


    public function deleteDocument(Request $request){
        try{
            $conference = Conference::where('id', $request->confid)->first();
            if($conference == null){
                 return response()->json([
                     'status' => 'error',
                     'message' => 'File not found'
                 ]);
            }
           $doc = Document::where('id', $request->id)->first();
           $doc->delete();
 
           return response()->json([
             'status' => 'success',
             'message' => 'File has been removed from conference documents'
          ]);
         }catch(Exception $e){
             Log::error($e);
             return response()->json([
                 'status' => 'error',
                 'message' => 'Unable to delete attachment. Please try again'
             ]);
         }
    }

}
