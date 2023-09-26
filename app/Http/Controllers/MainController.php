<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessAbstractSubmissionEmail;
use App\Jobs\ProcessRegistrationEmail;
use App\Jobs\ProcessVerificationEmail;
use App\Models\Conference;
use App\Models\Application;
use App\Models\ConferenceAbstract;
use App\Models\Document;
use App\Models\PaymentCategory;
use App\Models\PaymentMode;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MainController extends Controller
{

    public function login(){
        return view('app.login');
    }
    public function verifyReg(Request $request){
        $cid = $request->query('cid'. null);
        if($cid == null){
            return back();
        }
        $conference = Conference::where('token', $cid)->first();
        return view('app.verifyreg', compact('conference'));
    }

    public function sendRegEmail(Request $request){
        try{
            dispatch(new ProcessVerificationEmail('Register For Conference', $request->email, 'REGISTRATION',$request->conferenceid));
            return response()->json([
                'status' => 'success',
                'message' => 'An email with registration link has been sent to your email. Please visit your email to complete registration'
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to send email. Please try again'
            ]);
        }
    }

    public function verifyAbstract(Request $request){
        $cid = $request->query('cid'. null);
        if($cid == null){
            return back();
        }
        $conference = Conference::where('token', $cid)->first();
        return view('app.verifyabstract', compact('conference'));
    }

    public function sendAbstractEmail(Request $request){
        try{
            dispatch(new ProcessVerificationEmail('Submit An Abstract', $request->email, 'ABSTRACT',$request->conferenceid));
            return response()->json([
                'status' => 'success',
                'message' => 'An email with abstract submission link has been sent to your email. Please visit your email, follow the link to submit abstract'
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to send email. Please try again'
            ]);
        }
    }

    public function index(Request $request){
        $term = $request->query('term', null);
        if($term == null){
            $conferences = Conference::where('isopen', true)->get();
        }else{
            $conferences = Conference::where('isopen', true)->where('title', 'like', '%'.$term.'%')->get();
        }
        
        return view('app.home', compact('conferences'));
    }

    public function apply(Request $request){
        $cid = $request->query('cid'. null);
        if($cid == null){
            return back();
        }
        // $paymentmodes = PaymentMode::all();
        $conference = Conference::where('token', $cid)->first();
        return view('app.register',compact('conference'));
    }

    public function conferenceDetails(Request $request){
        $cid = $request->query('cid'. null);
        if($cid == null){
            return back();
        }
        $conference = Conference::where('token', $cid)->with('sponsors', 'payment_categories')->first();
        return view('app.conferencedetails', compact('conference'));
    }

    public function aboutConference(Request $request){
        $cid = $request->query('cid'. null);
        if($cid == null){
            return back();
        }
        $conference = Conference::where('token', $cid)->with('sponsors', 'payment_categories')->first();

        // if (!File::exists('/public/qrcodes/main/'.$conference->token.'/main_qrcode.svg')) {
        //         File::makeDirectory('/public/qrcodes/main/'.$conference->token, 0755, true);
        // }

        $path = "/public/qrcodes/main/".$conference?->token;

        if(!Storage::exists($path)){
            Storage::makeDirectory($path);
        }

        $brochure_url =  url('/conference-docs?cid='.$conference?->token.'&conferenceid='.$conference->id);
        QrCode::size(200)
            ->format('svg')
            ->generate($brochure_url, storage_path('app/public/qrcodes/main/'.$conference?->token.'/main_qrcode.svg'));

        return view('app.about', compact('conference'));
    }


    public function conferenceAbstract(Request $request){
        $cid = $request->query('cid'. null);
        if($cid == null){
            return back();
        }
        $paymentmodes = PaymentMode::all();
        $conference = Conference::where('token', $cid)->with('payment_categories')->first();
        return view('app.submitpaper', compact('conference', 'paymentmodes'));
    }


    // public function conferenceNewAbstract(Request $request){
    //     $cid = $request->query('cid'. null);
    //     if($cid == null){
    //         return back();
    //     }
    //     $paymentmodes = PaymentMode::all();
    //     $conference = Conference::where('token', $cid)->with('payment_categories')->first();
    //     return view('app.submitpaper', compact('conference', 'paymentmodes'));
    // }


    public function saveAbstract(Request $request){
        $abstract = null;
        try{
            // $application = Application::where('email', $request->email)->where('reg_no', $request->regno)->first();
            // if($application == null){
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Action unsuccessful. Please register to submit abstract'
            //     ]);
            // }
            
            if($request->hasFile('abstractfile')){
                $document = $request->file('abstractfile');
                $ext = $document->getClientOriginalExtension();
                $fname = $document->getClientOriginalName();
                $docfilename =  $fname.'.'.$ext;
                $document->move(base_path('/public/storage/abstracts'), $docfilename);

                $coauthornames = $request->coauthorname;
                $coauthoremails = $request->coauthoremail;



                $coauthors = [];
                if($coauthornames != null && is_array($coauthornames)){
                    for($i=0 ; $i<count($coauthornames) ; $i++){
                        array_push($coauthors, [
                            'name' => $coauthornames[$i],
                            'email' => $coauthoremails[$i]
                        ]);
                    }
                }

                $abstract = ConferenceAbstract::where('email', $request->email)->where('conference_id', $request->conferenceid)->first();
                if($abstract != null){
                    return response()->json([
                        'status' => 'error',
                        'message' => 'You have already submitted your abstract. Thank you.'
                    ]);
                }else{
                    $conference = Conference::where('id', $request->conferenceid)->first();
                    $theRegType = '';
                    $regtype = null;
                    if(isset($request->regtype)){
                        $regtype = PaymentCategory::where('id', $request->regtype)->first();
                        $theRegType = $regtype->name;
                    }else{
                        $theRegType = $request->occupation == 'Other' ? $request->occupation.' | '.$request->specify : $request->occupation;
                    }

                    $paymentmode = PaymentMode::where('id', $request->paymode)->first();

                    $regno = strtoupper(substr($conference?->title, 0, 3).mt_rand(100000, 9999999));

                    $application = Application::create([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'institution' => $request->institution,
                        'occupation' => $theRegType,
                        'extras' => json_encode([]),
                        'conference_token' => $request->cid,
                        'conference_id' => $conference?->id,
                        'title' => $request?->title,
                        'payment_category_id' => $request->regtype,
                        'payment_category_name' => $paymentmode?->name,
                        'reg_no' => $regno,
                        'reg_amount' => $regtype != null ? $regtype?->amount: "50",
                        'reg_currency' => $regtype != null ? $regtype?->currency: "GHS"
                    ]);
                   
                    $abstract = ConferenceAbstract::create([
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'title' => $request->title,
                        'corresponding_authorname' => $request->corresponding_author_name,
                        'corresponding_authoremail' => $request->corresponding_author_email,
                        'thematic' => $request->thematicarea,
                        'presentationtype' => $request->presentationtype,
                        'document' => $docfilename,
                        'coauthors' => json_encode($coauthors),
                        'institution' => $request->institution,
                        'conference_id' => $request->conferenceid,
                        'journal_publication' => $request->journal_publication,
                        'comments' => $request->comments
                    ]);

                    //create & save pdf for sending via email
                    $brochure_url =  url('/conference-docs?cid='.$conference?->token.'&conferenceid='.$conference->id.'&email='.$request->email);
                    QrCode::size(200)
                        ->format('svg')
                        ->generate($brochure_url, storage_path('app/public/qrcodes/'.$application->reg_no.'_qrcode.svg'));
                    $data =[
                        'application' => $application,
                        'conference' => $conference,
                        'abstract' => $abstract
                    ];
            
                    Pdf::loadView('pdf.abstractreg', $data)->save(storage_path('app/public/emails/Abstract_Proof_Of_Registration'.$regno.'.pdf'));

                    //send email with proof as attachment
                    dispatch(new ProcessAbstractSubmissionEmail($application, $conference, $request->email));


                }

               

                return response()->json([
                    'status' => 'success',
                    'url' => url('/abs-success?regno='.$regno.'&conference='.$conference->id.'&email='.$request->email),
                    'message' => 'Your abstract has been received. The team will contact you for the next step'
                ]);
            }else{
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please select your abstract to submit.'
                ]);
            }
        }catch(Exception $e){
            if($abstract != null){
                $abstract->delete();
            }
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Oops, something went wrong. Unable to submit abstract. Please try again'
            ]);
        }
    }


    // public function saveAbstract(Request $request){
    //     $abstract = null;
    //     try{
    //         if($request->hasFile('abstractfile')){
    //             $document = $request->file('abstractfile');
    //             $ext = $document->getClientOriginalExtension();
    //             $fname = $document->getClientOriginalName();
    //             $docfilename =  $fname.'.'.$ext;
    //             $document->move(base_path('/public/storage/abstracts'), $docfilename);

    //             $coauthornames = $request->coauthorname;
    //             $coauthoremails = $request->coauthoremail;



    //             $coauthors = [];
    //             if($coauthornames != null && is_array($coauthornames)){
    //                 for($i=0 ; $i<count($coauthornames) ; $i++){
    //                     array_push($coauthors, [
    //                         'name' => $coauthornames[$i],
    //                         'email' => $coauthoremails[$i]
    //                     ]);
    //                 }
    //             }

    //             $abstract = ConferenceAbstract::where('email', $request->email)->where('conference_id', $request->conferenceid)->first();
    //             if($abstract != null){
    //                 return response()->json([
    //                     'status' => 'error',
    //                     'message' => 'You have already submitted your abstract. Thank you.'
    //                 ]);
    //             }else{
    //                 $conference = Conference::where('id', $request->conferenceid)->first();
    //                 $theRegType = '';
    //                 $regtype = null;
    //                 if(isset($request->regtype)){
    //                     $regtype = PaymentCategory::where('id', $request->regtype)->first();
    //                     $theRegType = $regtype->name;
    //                 }else{
    //                     $theRegType = $request->occupation == 'Other' ? $request->occupation.' | '.$request->specify : $request->occupation;
    //                 }

    //                 $paymentmode = PaymentMode::where('id', $request->paymode)->first();

    //                 $regno = strtoupper(substr($conference?->title, 0, 3).mt_rand(100000, 9999999));
    //                 $application = Application::create([
    //                     'firstname' => $request->firstname,
    //                     'lastname' => $request->lastname,
    //                     'email' => $request->email,
    //                     'phone' => $request->phone,
    //                     'institution' => $request->institution,
    //                     'occupation' => $theRegType,
    //                     'extras' => json_encode([]),
    //                     'conference_token' => $request->cid,
    //                     'conference_id' => $conference?->id,
    //                     'title' => $request?->title,
    //                     'payment_category_id' => $request->regtype,
    //                     'payment_category_name' => $paymentmode?->name,
    //                     'reg_no' => $regno,
    //                     'reg_amount' => $regtype != null ? $regtype?->amount: "0",
    //                     'reg_currency' => $regtype != null ? $regtype?->currency: "GHS"
    //                 ]);
    //                 $abstract = ConferenceAbstract::create([
    //                     'firstname' => $request->firstname,
    //                     'lastname' => $request->lastname,
    //                     'email' => $request->email,
    //                     'phone' => $request->phone,
    //                     'title' => $request->title,
    //                     'corresponding_authorname' => $request->corresponding_author_name,
    //                     'corresponding_authoremail' => $request->corresponding_author_email,
    //                     'thematic' => $request->thematicarea,
    //                     'presentationtype' => $request->presentationtype,
    //                     'document' => $docfilename,
    //                     'coauthors' => json_encode($coauthors),
    //                     'institution' => $request->institution,
    //                     'conference_id' => $request->conferenceid,
    //                     'journal_publication' => $request->journal_publication,
    //                     'comments' => $request->comments
    //                 ]);

    //                 //create & save pdf for sending via email
    //                 $brochure_url =  url('/conference-docs?cid='.$conference?->token.'&conferenceid='.$conference->id.'&email='.$request->email);
    //                 QrCode::size(200)
    //                     ->format('svg')
    //                     ->generate($brochure_url, storage_path('app/public/qrcodes/'.$application->reg_no.'_qrcode.svg'));
    //                 $data =[
    //                     'application' => $application,
    //                     'conference' => $conference,
    //                     'abstract' => $abstract
    //                 ];
            
    //                 Pdf::loadView('pdf.abstractreg', $data)->save(storage_path('app/public/emails/Abstract_Proof_Of_Registration'.$regno.'.pdf'));

    //                 //send email with proof as attachment
    //                 dispatch(new ProcessAbstractSubmissionEmail($application, $conference, $request->email));


    //             }

               

    //             return response()->json([
    //                 'status' => 'success',
    //                 'url' => url('/abs-success?regno='.$regno.'&conference='.$conference->id.'&email='.$request->email),
    //                 'message' => 'Your abstract has been received. The team will contact you for the next step'
    //             ]);
    //         }else{
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Please select your abstract to submit.'
    //             ]);
    //         }
    //     }catch(Exception $e){
    //         if($abstract != null){
    //             $abstract->delete();
    //         }
    //         Log::error($e);
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Oops, something went wrong. Unable to submit abstract. Please try again'
    //         ]);
    //     }
    // }


    public function applyForConference(Request $request){
        $application = null;
        try{
            $conference = Conference::where('token', $request->cid)->first();
            $application = Application::where('email', $request->email)->where('conference_id', $conference?->id)->first();
            if($application != null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'You have already registered for conference using the email '.$request->email
                ]);
            }
            
            $regno = strtoupper(mt_rand(1000, 999999999));
            $application = Application::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'house' => $request->house,
                'yeargroup' => $request->yeargroup,
                'occupation' => '',
                'extras' => json_encode([]),
                'conference_token' => $request->cid,
                'conference_id' => $conference?->id,
                'title' => $request->title,
                'reg_no' => $regno,
                'amount' => $request->amount,
                'reg_amount' => $request->amount,
                'reg_currency' => "GHS"
            ]);


            $user = User::where('email', $request->email)->first();
            if($user == null) {
                User::create([
                    'email' => $request->email,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'phone' => $request->phone,
                    'house' => $request->house,
                    'yeargroup' => $request->yeargroup,
                    'whatsapp' => $request->whatsapp,
                    'password' => Hash::make("Omsu@".$request->yeargroup)
                ]);
            }

            // $brochure_url =  url('/conference-docs?cid='.$conference?->token.'&conferenceid='.$conference->id.'&email='.$request->email);
            // QrCode::size(200)
            //     ->format('svg')
            //     ->generate($brochure_url, storage_path('app/public/qrcodes/'.$application->reg_no.'_qrcode.svg'));
            // $data =[
            //     'application' => $application,
            //     'conference' => $conference
            // ];
    
            // Pdf::loadView('pdf.registration', $data)->save(storage_path('app/public/emails/Proof_Of_Registration'.$regno.'.pdf'));

            // dispatch(new ProcessRegistrationEmail($application, $conference, $request->email));

            return response()->json([
                'status' => 'success',
                'token' => $conference->token,
                'email' => $request->email,
                'regno' => $regno,
                'url' => url('/reg-success?regno='.$regno.'&conference='.$conference->id.'&email='.$request->email),
                'message' => 'Make the payment of GHC 150 to complete you registration '
            ]);
        }catch(Exception $e){
            if($application != null){
                $application->delete();
            }
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Oops, Unable to register for event/conference. Please try again later'
            ]);
        }
    }


    public function completeRegistration(Request $request){
        try{
            $application = Application::where('reg_no', $request->regno)->where('email', $request->email)->first();
            $application->update([
                'paid' => "Yes",
                'reference' => $request->reference,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully registered for OMSU Congress - 2023. Please enter password to login to OMSU portal'
            ]);
        }catch(Exception $e){
            Log::info("PAYMENT SUCCESSFULL BUT UNABLE TO COMPLETE USER REGISTRATION");
            Log::info($request->all());
            return response()->json([
                'status' => 'error',
                'message' => 'OOps something went wrong. Please contact admin to rectify issue'
            ]);
        }
    }

     public function authenticate(Request $request){
        if( Auth::attempt(['email' => $request->email, 'password' => $request->password ])){
            return response()->json([
                'status' => 'success',
                'url' => url('/profile'),
                'message' => 'Login successful. Redirecting to admin dashboard'
            ]);
       }else{
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid Username or Password'
        ]);
       }
     }


    public function setAccountPassword(Request $request){
        try{
            $user = User::where('email', $request->email)->first();
            if($user == null){
                return response()->json([
                    'status' => 'error',
                    'message' => 'OOps something went wrong. Unable to set password'
                ]);
            }
            $user->update([
                'password' => Hash::make($request->password)
            ]);

           if( Auth::attempt(['email' => $request->email, 'password' => $request->password ])){
                $request->session()->regenerate();
           }
            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully set your OMSU global password'
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'OOps something went wrong. Unable to set password'
            ]);
        }
    }



    public function myOmsuDhasboard(){
        return view('app.dashboard');
    }




















    /**
     * 
     * 
     * 
     * 
     * 
     * 
     */

    public function downloadAbstractTemplate(Request $request){
        try{
            $conference = Conference::where('token', $request->cid)->first();
            $files = json_decode($conference->attachments);

            Log::info($files);
            
            $name = 'CONFERENCE_ATTACHMENTS_'.$conference->token.'_FILES.zip';

            if (file_exists(storage_path('app/downloads/'.$name))) {
                Log::info("Existing so no creation");
                $storePath = storage_path('app/downloads/'.$name);
                return response()->download($storePath);
            }else{
                 // Get real path for our folder
                // $rootPath = realpath('folder-to-zip');
                // $rootPath = storage_path('app/downloads');
                $storePath = storage_path('app/downloads/'.$name);

                if (!File::exists(storage_path('app/downloads/'))) {
                    File::makeDirectory(storage_path('app/downloads/'), 0755, true);
                }
                // Initialize archive object
                $zip = new ZipArchive();
                $zip->open($storePath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

                foreach ($files as $file)
                {
                    $zip->addFile(storage_path().'/app/attachments/'.$file, $file);
                }
                // Zip archive will be created only after closing object
                $zip->close();

                return response()->download($storePath);
            }

            

        }catch(Exception $e){
            Log::error($e);
            return back()->with('error', 'Unable to download file');
        }
        
    }

    public function getRegAmount(Request $request){
        try{
            $pay_cat = PaymentCategory::where('id', $request->id)->first();
            return response()->json([
                'status' => 'success',
                'amount' => $pay_cat->amount,
                'pay' =>$pay_cat
            ]);
        }catch(Exception $e){
            Log::error($e);
            return response()->json([
                'status' => 'error',
                'message' => 'Unable to get registration amount'
            ]);
        }
    }


    public function regSuccess(Request $request){
        $regno = $request->query('regno', null);
        $conferenceid = $request->query('conference', null);
        $email = $request->query('email', null);

        if($regno == null || $conferenceid == null){
            return back();
        }

        $application = Application::where('reg_no', $regno)->where('conference_id', $conferenceid)->where('email', $email)->first();

        if($application == null){
            return back();
        }

        $conference = Conference::where('id', $conferenceid)->first();
        $message = "You have successfully registered for ".$conference->title;

        return view('app.regsuccess', compact('application', 'message', 'conference'));
    }


    public function absSuccess(Request $request){
        $regno = $request->query('regno', null);
        $conferenceid = $request->query('conference', null);
        $email = $request->query('email', null);

        if($regno == null || $conferenceid == null){
            return back();
        }

        $application = Application::where('reg_no', $regno)->where('conference_id', $conferenceid)->where('email', $email)->first();

        if($application == null){
            return back();
        }

        $conference = Conference::where('id', $conferenceid)->first();
        $message = "You have successfully submitted your abstract for conference : ".$conference->title;

        return view('app.abssuccess', compact('application', 'message', 'conference'));
    }


    public function downloadProof(Request $request){
        $regno = $request->query('regno', null);
        $email = $request->query('email', null);

        if($regno == null || $email == null){
            return back()->with('error', 'Registration info not available. Unable to generate proof');
        }

        $application = Application::where('email', $email)->where('reg_no', $regno)->first();
        $conference = Conference::where('id', $application?->conference_id)->first();
        $data = [
            'application' => $application,
            'conference' => $conference
        ];

        
        // $brochure_url = url('/download-brochure?cid='.$conference?->token.'&conferenceid='.$conference->id.'&email='.$email);
        $brochure_url = url('/conference-docs?cid='.$conference?->token.'&conferenceid='.$conference->id.'&email='.$email);
        QrCode::size(200)
            ->format('svg')
            ->generate($brochure_url, storage_path('app/public/qrcodes/'.$application->reg_no.'_qrcode.svg'));
        

        $pdf = Pdf::loadView('pdf.registration', $data);
        // $pdf->setPaper('L');
        // $pdf->output();
        // $canvas = $pdf->getDomPDF()->getCanvas();

        // $height = $canvas->get_height();
        // $width = $canvas->get_width();

        // $canvas->set_opacity(.05,"Multiply");

        // $canvas->set_opacity(.05);

        // $canvas->page_text($width/5, $height/1.5, 'PROOF OF REGISTRATION', null,
        //     40, array(0,0,0),2,2,-40);
        // return $pdf->download('Proof_Of_Registration.pdf');
        return $pdf->stream();
    }

    public function downloadAbstractProof(Request $request){
        $regno = $request->query('regno', null);
        $email = $request->query('email', null);

        if($regno == null || $email == null){
            return back()->with('error', 'Registration info not available. Unable to generate proof');
        }

        $application = Application::where('email', $email)->where('reg_no', $regno)->first();
        $conference = Conference::where('id', $application?->conference_id)->first();
        $data = [
            'application' => $application,
            'conference' => $conference,
            'abstract' => ConferenceAbstract::where('email', $email)->where('conference_id', $conference->id)->first()
        ];

        
        // $brochure_url =  url('/download-brochure?cid='.$conference?->token.'&conferenceid='.$conference->id.'&email='.$email);
        $brochure_url = url('/conference-docs?cid='.$conference?->token.'&conferenceid='.$conference->id.'&email='.$email);
        QrCode::size(200)
            ->format('svg')
            ->generate($brochure_url, storage_path('app/public/qrcodes/'.$application->reg_no.'_qrcode.svg'));
        

        $pdf = Pdf::loadView('pdf.abstractreg', $data);
        return $pdf->stream();
    }


    public function downloadBrochure(Request $request){
        $conferencetoken = $request->query('cid', null);
        $id = $request->query('conferenceid', null);
        $email = $request->query('email', null);

        $conference = Conference::where('id', $id)->first();

        if($conference == null || $conference->brochure == null){
            return redirect()->to('/no-brochure?cid='.$conference->id);
        }else{
            return redirect()->to(asset('/storage/brochure/'.$conference->brochure));
        }
    }

    public function noBrochure(Request $request){
        $conference = Conference::where('id', $request->query('cid', null))->first();
        return view('app.nobrocure', compact('conference'));
    }

    public function conferenceDocs(Request $request){
        $conferencetoken = $request->query('cid', null);
        $id = $request->query('conferenceid', null);
        $email = $request->query('email', null);

        $conference = Conference::where('id', $id)->first();
        if($conference == null || $conference->brochure == null){
            return redirect()->to('/no-brochure?cid='.$conference->id);
        }else{
            $documents = Document::where('conference_id', $conference->id)->get();
            return view('app.conferencedocs', compact('documents', 'conference'));
        } 
    }


    
}

