<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Subscriber;
use App\Models\SubscriberSubscription;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Mail\RequestReply;
use App\Models\Discipline;
use App\Models\Advert;
use App\Models\Partner;
use App\Models\Request as Applications;
use GuzzleHttp\Psr7\Response;
use Mail;
use Illuminate\Support\Str;
use Psy\Readline\Hoa\Console;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

class PagesController extends Controller
{
    public function Index()
    {
        $scholarships = Discipline::where('category', 'scholarship')
        ->where('status', '<>', 'N/A')
        ->where('speciality', '!=', 'carousel')
        ->orderBy('publish_date', 'desc')
        ->get();


        $opportunity = Discipline::where('category', 'Job')
            ->where('status', '<>', 'N/A')
            ->where('speciality', '!=', 'carousel')
            ->orderBy('publish_date', 'desc')
            ->get();

        $trainings = Discipline::where('status', '<>', 'N/A')
            ->where('speciality', '!=', 'carousel')
            ->whereNotIn('category', ['scholarship', 'Job'])
            ->orderBy('publish_date', 'desc')
            ->get();

        $sidebarData = Discipline::where('speciality', 'Trendings')
            ->where('status', '<>', 'N/A')
            ->where('speciality', '!=', 'carousel')
            ->orderBy('publish_date', 'desc')
            ->get();

        $carouselData = Discipline::where('speciality', 'carousel')
            ->where('status', '<>', 'N/A')
            ->orderBy('publish_date', 'desc')
            ->get();

        $ads = Advert::where('status', 'active')->get();

        $partners = Partner::where('status', 'active')->get();

        return view(
            'index',
            compact(
                'scholarships',
                'opportunity',
                'trainings',
                'sidebarData',
                'carouselData',
                'ads',
                'partners',
            )
        );
    }

    public function BeScholar()
    {
        $scholarships = DB::table('disciplines')->where('category', 'scholarship')->where('status', '<>', 'N/A')->orderBy('publish_date', 'desc')->get();
        $motivation = DB::table('motivation')->inRandomOrder()->first();
        $faqs = DB::table('faqs')->get();
        $avai_scholarships = count($scholarships);
        $community = count(DB::table('served_requests')->get());
        $countries = DB::table('disciplines')->where('category', 'scholarship')->distinct('country')->count();

        return view('be-a-scholar', compact('scholarships', 'motivation', 'faqs', 'avai_scholarships', 'community', 'countries'));
    }

    public function testimonies()
    {

        $motivation = DB::table('motivation')->get();

        return view('admin.testimonies', compact('motivation'));
    }

    public function edit_testmony_form(Request $request)
    {

        $testmony = DB::table('motivation')->where('id', $request->testmony)->first();

        return view('admin.edit-testmony', compact('testmony'));

    }

    public function post_testmony(Request $request)
    {


        $request->validate([
            'profile_image' => ['required']
        ]);

        $image = time() . '-' . $request->profile_image->getClientOriginalName();
        $request->profile_image->move(public_path('images/'), $image);

        DB::table('motivation')->insert([
            'motivator_names' => $request->names,
            'phone_number' => $request->phone,
            'motivation_theme' => $request->theme,
            'motivation_sentence' => $request->subtitle,
            'motivation' => $request->content,
            'motivator_pp' => $image
        ]);

        return Auth::user() ? redirect()->route('testimonies') : redirect()->route('md.testimonies');

    }

    public function edit_testmony(Request $request)
    {

        if (File::exists(public_path('images/' . $request->old_pp))) {
            File::delete(public_path('images/' . $request->old_pp));
        }

        $image = time() . '-' . $request->profile_image->getClientOriginalName();
        $request->profile_image->move(public_path('images/'), $image);


        DB::table('motivation')->limit(1)->where('id', $request->id)->update([
            'motivator_names' => $request->names,
            'phone_number' => $request->phone,
            'motivation_theme' => $request->theme,
            'motivation_sentence' => $request->subtitle,
            'motivation' => $request->content,
            'motivator_pp' => $image
        ]);

        return back();
    }

    public function delete_testmony(Request $request)
    {

        if (File::exists(public_path('images/' . $request->file))) {
            File::delete(public_path('images/' . $request->file));
        }

        DB::table('motivation')->delete($request->id);

        return redirect()->route('testimonies');
    }

    public function get_employed()
    {
        $jobs = DB::table('disciplines')->where('category', 'job')->where('status', '<>', 'N/A')->orderBy('publish_date', 'desc')->get();
        $motivation = DB::table('motivation')->inRandomOrder()->first();
        $faqs = DB::table('faqs')->get();
        $avai_jobs = count($jobs);
        $community = count(DB::table('served_requests')->get());
        $organizations = DB::table('disciplines')->where('category', 'job')->distinct('organization')->count();

        return view('get-employed', compact('jobs', 'motivation', 'faqs', 'avai_jobs', 'community', 'organizations'));
    }

    public function about_us()
    {
        $info = Company::first();
        return view('about-us', compact('info'));
    }

    public function contact_us()
    {
        return view('contact-us');
    }

    public function felowships_trainings()
    {
        $f_trainings = DB::table('disciplines')
            ->where('status', '<>', 'N/A')
            ->where(function ($query) {
                $query->where('category', 'training')
                    ->orWhere('category', 'fellowship');
            })
            ->orderBy('publish_date', 'desc')
            ->get();

        $motivation = DB::table('motivation')->inRandomOrder()->first();
        $faqs = DB::table('faqs')->get();
        $avai_trainings = count($f_trainings);
        $community = count(DB::table('served_requests')->get());
        $fships_trainings = DB::table('disciplines')
            ->where('category', 'training')
            ->orWhere('category', 'fellowship')
            ->distinct('organization')
            ->count();

        return view('felowships-trainings', compact('f_trainings', 'motivation', 'faqs', 'avai_trainings', 'community', 'fships_trainings'));
    }

    public function client_apply(Request $request)
    {
        $existing_applicant_info = DB::table('applicant_info')->where('id', Auth::guard('client')->user()->id)->first();
        $existing_applicant_background[] = DB::table('applicant_education_info')->where('applicant', Auth::guard('client')->user()->id)->get();
        $existing_applicant_documents[] = DB::table('applicant_documents')->where('applicant', Auth::guard('client')->user()->id)->get();

        $application_info = DB::table('disciplines')->where('identifier', $request->discipline_id)->first();

        return view('client.client-apply', compact('application_info', 'existing_applicant_info', 'existing_applicant_background', 'existing_applicant_documents'));
    }

    public function follow_up_options(Request $request)
    {

        return view('follow-up', ['discipline' => $request->discipline, 'app_id' => $request->app_id, 'applicant' => $request->applicant]);
    }

    public function finish(Request $request)
    {

        return view('finish', ['discipline' => $request->discipline, 'app_id' => $request->app_id, 'applicant' => $request->applicant, 'message' => $request->message, 'subcontent' => $request->subcontent]);
    }

    public function client_dashboard(Request $request)
    {

        $query = $request->get('status');
        $pending_applications = DB::table('user_requests')->where('id', Auth::guard('client')->user()->id)->orderBy('requested_on', 'desc')->get();

        if ($query) {
            $pending_applications = DB::table('user_requests')->where('id', Auth::guard('client')->user()->id)->where('status', $query)->orderBy('requested_on', 'desc')->get();
        }

        $scholarships = DB::table('disciplines')->where('category', 'Scholarship')->where('status', 'Available')->orderBy('publish_date', 'desc')->get();
        $jobs = DB::table('disciplines')->where('category', 'Job')->where('status', 'Available')->orderBy('publish_date', 'desc')->get();
        $trainings = DB::table('disciplines')->where('status', 'Available')->where('category', '<>', 'Scholarship')->where('category', '<>', 'Job')->orderBy('publish_date', 'desc')->get();

        $subRecord = Subscriber::where('email', auth()->guard('client')->user()->email)->first();
        $subscription = null;
        if ($subRecord) {
            $subscription = SubscriberSubscription::where('subscriber_id', $subRecord->id)->first();
        }

        $appointments = Applications::where('is_appointment', 1)
            ->where('applicant', Auth::guard('client')->user()->id)
            ->get();

        return view('client.client-dashboard', compact('scholarships', 'jobs', 'trainings', 'pending_applications', 'subscription', 'appointments'));
    }

    public function discipline_learn_more(Request $request)
    {
        $discipline = DB::table('disciplines')->where('identifier', $request->discipline_id)->first();
        $included_arr = DB::table('disciplines')->select('includes')->where('identifier', $request->discipline_id)->get();
        $faqs = DB::table('faqs')->get();

        $app = Discipline::where('identifier', $request->discipline_id)->first();

        $comments = Comment::where('discipline_id', $app->id)
            ->where(function ($query) use ($app) {
                $query->where('status', 'active');
                if (Auth::guard('client')->check()) {
                    $query->orWhere('applicant_id', Auth::guard('client')->user()->id);
                }
            })
            ->with('replies')
            ->get();


        if ($discipline) {
            return view('card-learnmore', compact('discipline', 'faqs', 'comments'));
        } else {
            return redirect()->route('home');
        }
    }

    public function visit_official_web(Request $request)
    {

        $the_link = DB::table('disciplines')->where('identifier', $request->discipline_id)->select('website_link')->first();

        return redirect()->away($the_link->website_link);
    }

    public function client_item_learn_more(Request $request)
    {

        $disciplines[] = DB::table('disciplines')->where('identifier', $request->discipline_id)->first();
        $included_arr = DB::table('disciplines')->select('includes')->where('identifier', $request->discipline_id)->get();

        $faqs = DB::table('faqs')->get();

        return view('client.client-learnmore', compact('disciplines', 'faqs'));
    }

    public function client_profile()
    {
        $client_info = DB::table('applicant_info')->where('id', Auth::guard('client')->user()->id)->first();
        $client_background = DB::table('applicant_education_info')->where('applicant', Auth::guard('client')->user()->id)->get();
        $client_docs = DB::table('applicant_documents')->where('applicant', Auth::guard('client')->user()->id)->get();

        return view('client.client-profile', compact('client_info', 'client_background', 'client_docs'));
    }

    public function delete_document(Request $request)
    {
        DB::table('applicant_documents')->where('id', $request->document_id)->delete();

        return back();
    }

    public function profile_update(Request $request)
    {
        $validateData = $request->validate([
            'names' => ['required'],
            'email' => ['email', 'max:255', Rule::unique('applicant_info')->ignore(Auth::guard('client')->user()->id)],
            'phone_number' => ['required'],
            'birth_date' => ['required'],
            'gender' => ['required'],
            // 'father_name' => ['required'],
            // 'faher_email' => ['required'],
            // 'father_phone' => ['required'],
            // 'mother_name' => ['required'],
            // 'mother_email' => ['required'],
            // 'mother_phone' => ['required'],
            // 'parents_alive' => ['required'],
            // 'country' => ['required'],
            // 'province' => ['required'],
            // 'city' => ['required'],
            // 'document' => ['required', 'mimes:pdf,docx,rtf,txt|max:1024'],
            // 'profile_image' => ['required']
        ]);

        if ($request->hasFile('profile_image')) {

            $profile_image = time() . '-' . $request->file('profile_image')->getClientOriginalName();

            if (File::exists(public_path('profile_pictures/' . $request->old_pp))) {
                File::delete(public_path('profile_pictures/' . $request->old_pp));
            }
            $request->file('profile_image')->move(public_path('profile_pictures/'), $profile_image);

            $data = [
                'names' => $request->names,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'dob' => $request->birth_date,
                'gender' => $request->gender,
                'father_names' => $request->father_name,
                'father_email' => $request->faher_email,
                'father_phone' => $request->father_phone,
                'mother_names' => $request->mother_name,
                'mother_email' => $request->mother_email,
                'mother_phone' => $request->mother_phone,
                'parents_alive' => $request->parents_alive,
                'guardian' => $request->guardian,
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
                'profile_picture' => $profile_image,
            ];

            DB::table('applicant_info')->where('id', Auth::guard('client')->user()->id)->limit(1)->update($data);
        } else {
            $data = [
                'names' => $request->names,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'dob' => $request->birth_date,
                'gender' => $request->gender,
                'father_names' => $request->father_name,
                'father_email' => $request->faher_email,
                'father_phone' => $request->father_phone,
                'mother_names' => $request->mother_name,
                'mother_email' => $request->mother_email,
                'mother_phone' => $request->mother_phone,
                'parents_alive' => $request->parents_alive,
                'guardian' => $request->guardian,
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
            ];
            DB::table('applicant_info')->where('id', Auth::guard('client')->user()->id)->limit(1)->update($data);
        }


        $applicant_info = DB::table('applicant_info')->where('email', $request->email)->first();
        $applicant_education_info = [];
        $applicant_documents = [];

        if (!is_null($request->education_level)) {

            foreach ($request->education_level as $key => $level) {

                if (
                    !DB::table('applicant_education_info')
                        ->where('applicant', Auth::guard('client')->user()->id)
                        ->Where('education_level', $level)
                        ->orWhere('institution', $request->institution[$key])
                        ->orWhere('graduation_date', $request->graduation_date[$key])
                        ->first()
                ) {

                    array_push($applicant_education_info, [
                        'applicant' => Auth::guard('client')->user()->id,
                        'education_level' => $level,
                        'institution' => $request->institution[$key],
                        'graduation_date' => $request->graduation_date[$key],
                    ]);

                } else {
                    DB::table('applicant_education_info')
                        ->limit(1)
                        ->where('education_level', $level)
                        ->orWhere('institution', $request->institution[$key])
                        ->orWhere('graduation_date', $request->graduation_date[$key])
                        ->where('applicant', Auth::guard('client')->user()->id)
                        ->update([
                            'education_level' => $level,
                            'institution' => $request->institution[$key],
                            'graduation_date' => $request->graduation_date[$key]
                        ]);
                }
            }

        }

        DB::table('applicant_education_info')->insert($applicant_education_info);


        if (!empty($request->file('document'))) {
            foreach ($request->file('document') as $key => $file) {

                if ($file != null) {
                    $document = time() . '-' . $file->getClientOriginalName();
                    $file->move(public_path('documents/'), $document);

                    array_push($applicant_documents, [
                        'applicant' => Auth::guard('client')->user()->id,
                        'document' => $document,
                    ]);
                }
            }
        }

        DB::table('applicant_documents')->insert($applicant_documents);


        return back();
    }

    public function profile_info_update(Request $request)
    {
        $validateData = $request->validate([
            'names' => ['required'],
            'email' => ['email', 'max:255', Rule::unique('applicant_info')->ignore($request->client_id)],
            'phone_number' => ['required'],
        ]);

        if ($request->hasFile('profile_image')) {

            $profile_image = time() . '-' . $request->file('profile_image')->getClientOriginalName();

            if (File::exists(public_path('profile_pictures/' . $request->old_pp))) {
                File::delete(public_path('profile_pictures/' . $request->old_pp));
            }
            $request->file('profile_image')->move(public_path('profile_pictures/'), $profile_image);

            $data = [
                'names' => $request->names,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'dob' => $request->birth_date,
                'gender' => $request->gender,
                'father_names' => $request->father_name,
                'father_email' => $request->faher_email,
                'father_phone' => $request->father_phone,
                'mother_names' => $request->mother_name,
                'mother_email' => $request->mother_email,
                'mother_phone' => $request->mother_phone,
                'parents_alive' => $request->parents_alive,
                'guardian' => $request->guardian,
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
                'profile_picture' => $profile_image,
            ];

            DB::table('applicant_info')->where('id', $request->client_id)->limit(1)->update($data);
        } else {
            $data = [
                'names' => $request->names,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'dob' => $request->birth_date,
                'gender' => $request->gender,
                'father_names' => $request->father_name,
                'father_email' => $request->faher_email,
                'father_phone' => $request->father_phone,
                'mother_names' => $request->mother_name,
                'mother_email' => $request->mother_email,
                'mother_phone' => $request->mother_phone,
                'parents_alive' => $request->parents_alive,
                'guardian' => $request->guardian,
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
            ];
            DB::table('applicant_info')->where('id', $request->client_id)->limit(1)->update($data);
        }


        $applicant_info = DB::table('applicant_info')->where('email', $request->email)->first();
        $applicant_education_info = [];
        $applicant_documents = [];

        if (!is_null($request->education_level)) {

            foreach ($request->education_level as $key => $level) {

                if (
                    !DB::table('applicant_education_info')
                        ->where('applicant', $request->client_id)
                        ->Where('education_level', $level)
                        ->orWhere('institution', $request->institution[$key])
                        ->orWhere('graduation_date', $request->graduation_date[$key])
                        ->first()
                ) {

                    array_push($applicant_education_info, [
                        'applicant' => $request->client_id,
                        'education_level' => $level,
                        'institution' => $request->institution[$key],
                        'graduation_date' => $request->graduation_date[$key],
                    ]);

                } else {
                    DB::table('applicant_education_info')
                        ->limit(1)
                        ->where('education_level', $level)
                        ->orWhere('institution', $request->institution[$key])
                        ->orWhere('graduation_date', $request->graduation_date[$key])
                        ->where('applicant', $request->client_id)
                        ->update([
                            'education_level' => $level,
                            'institution' => $request->institution[$key],
                            'graduation_date' => $request->graduation_date[$key]
                        ]);
                }
            }

        }

        DB::table('applicant_education_info')->insert($applicant_education_info);


        if (!empty($request->file('document'))) {
            foreach ($request->file('document') as $key => $file) {

                if ($file != null) {
                    $document = time() . '-' . $file->getClientOriginalName();
                    $file->move(public_path('documents/'), $document);

                    array_push($applicant_documents, [
                        'applicant' => $request->client_id,
                        'document' => $document,
                    ]);
                }
            }
        }

        DB::table('applicant_documents')->insert($applicant_documents);


        return back();
    }


    public function delete_background(Request $request)
    {

        DB::table('applicant_education_info')->delete($request->back_id);

        return back();

    }


    public function search(Request $request)
    {

        $keyWord = $request->search_keyword;
        $results = DB::table('disciplines')->where('status', '<>', 'N/A')->where('discipline_name', 'LIKE', '%' . $keyWord . '%')->distinct()->get();

        if ($results->isNotEmpty()) {

            $sugCheck = DB::table('search_suggestions')->where('keyword', $keyWord)->first();

            if ($sugCheck) {
                DB::table('search_suggestions')->where('keyword', $keyWord)->update(['count' => $sugCheck->count + 1]);
            } else {
                DB::table('search_suggestions')->insert([
                    'keyword' => $keyWord,
                    'count' => 1
                ]);
            }

        } elseif (!DB::table('search_suggestions')->where('keyword', $keyWord)->first()) {
            DB::table('search_suggestions')->insert([
                'keyword' => $keyWord,
            ]);
        } else {
            //
        }

        $sidebarData = DB::table('disciplines')->where('status', '<>', 'N/A')->where('speciality', 'special')->get();

        return view('search-results', compact('sidebarData', 'results', 'keyWord'));

    }

    public function seek_assistance(Request $request)
    {

        $request->validate([
            'names' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'issue' => 'required',
            'desc' => 'required'
        ]);

        $requestInfo = [
            'names' => $request->names,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'issue' => $request->issue,
            'issue_desc' => $request->desc,
        ];

        if (DB::table('assistance_seekings')->insert($requestInfo)) {

            return back()->with('scs', $request->names);

        } else {
            return back()->with('failed', $request->names);
        }

    }

    public function request_reply(Request $request)
    {

        if (Auth::user()) {

            if (DB::table('assistance_seekings')->limit(1)->where('id', $request->client_id)->update(['assistance_given' => $request->reply, 'assistant' => Auth::user()->name])) {

                $request_info = DB::table('assistance_seekings')->where('id', $request->client_id)->first();

                $question = $request_info->issue_desc;
                $client = $request_info->names;
                $answer = $request->reply;

                Mail::to($request_info->email)->send(new RequestReply($question, $client, $answer));

            }

        } else {



            DB::table('assistance_seekings')->limit(1)->where('id', $request->client_id)->update(['assistance_given' => $request->reply, 'assistant' => Auth::guard('staff')->user()->names]);

            $request_info = DB::table('assistance_seekings')->where('id', $request->client_id)->first();

            $question = $request_info->issue_desc;
            $client = $request_info->names;
            $answer = $request->reply;

            Mail::to($request_info->email)->send(new RequestReply($question, $client, $answer));

        }

        return back();
    }

    public function faqs()
    {

        $faqs = DB::table('faqs')->get();

        return view('admin.faqs', compact('faqs'));
    }


    public function edit_faqs(Request $request)
    {

        DB::table('faqs')->limit(1)->where('id', $request->faq)->update([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return back();

    }

    public function post_faqs(Request $request)
    {

        DB::table('faqs')->insert([
            'question' => $request->question,
            'answer' => $request->answer
        ]);

        return back();

    }


    public function delete_faq(Request $request)
    {

        DB::table('faqs')->delete($request->id);

        return back();

    }

    public function subscribe(Request $request)
    {

        $messages = [
            'g-recaptcha-response.required' => 'Please complete the CAPTCHA to proceed.',
            'g-recaptcha-response.captcha' => 'The CAPTCHA verification failed, please try again.',
        ];

        $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'g-recaptcha-response' => 'required|captcha',
        ], $messages);

        if (!DB::table('subscribers')->where('email', $request->email)->first())
            DB::table('subscribers')->insert(['email' => $request->email]);

        setcookie('client_email', $request->email, time() + (365 * 24 * 60 * 60), "/", 'www.bscholarz.com');

        return back();

    }

    public function staff_disbursements(Request $request)
    {

        $member = DB::table('staff')->where('id', $request->assistant)->first();
        $balance = DB::table('served_requests')->where('assistant', $request->assistant)->where('application_status', 'Complete')->get();
        $history = DB::table('disbursement_history')->where('assistant', $request->assistant)->orderBy('date_time', 'DESC')->get();

        return view('disbursements', compact('member', 'balance', 'history'));

    }

    public function faq()
    {
        $faqs = DB::table('faqs')->get();

        return view('faq', compact('faqs'));
    }

    public function comment(Request $request)
    {
        $request->validate([
            'comment' => 'required',
            'discipline_id' => 'required',
            'applicant_id' => 'required',
        ]);

        $comment = Comment::create([
            'comment' => $request->comment,
            'discipline_id' => $request->discipline_id,
            'applicant_id' => $request->applicant_id,
        ]);

        return back();
    }

    public function tac() {
        return view('tac');
    }

    public function iremboInvoice() {
        return view('irembo-pay');
    }

    public function createInvoice(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'customerName' => 'required|string|max:100',
        'customerEmail' => 'required|email|max:100',
        'phoneNumber' => 'required|string|max:20|regex:/^[0-7][0-9]{7,}$/',
        'amount' => 'required|numeric|min:0'
    ]);

    // Generate unique IDs
    $transactionId = 'TST-' . Str::random(3);
    $itemCode = 'PC-e231f638f0';
    $endpoint = env('PAYMENT_URL');
    $secret_key = env('SECRET_KEY');
    $api_version = env('API_VERSION');

    // Prepare the data for the cURL request
    $data = [
        'transactionId' => $transactionId,
        'paymentAccountIdentifier' => 'BSCHOLARZ_RWF',
        'customer' => [
            'email' => $validatedData['customerEmail'],
            'phoneNumber' => $validatedData['phoneNumber'], // Send as string as per your provided structure
            'name' => $validatedData['customerName']
        ],
        'paymentItems' => [
            [
                'unitAmount' => (float) $validatedData['amount'],
                'quantity' => 1,
                'code' => $itemCode
            ]
        ],
        'description' => 'Invoice for ' . $validatedData['customerName'],
        'expiryAt' => now()->addDays(30)->toIso8601String(), // Adjust the expiry time here if needed
        'language' => 'EN'
    ];

    // cURL setup
    $ch = curl_init($endpoint);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'irembopay-secretKey: ' . $secret_key,
        'X-API-Version: ' . $api_version,
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));  // Send the data as JSON

    // Execute cURL request and get the response
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        return response()->json([
            'success' => false,
            'error' => curl_error($ch)
        ], 500);
    }

    // Close the cURL session
    curl_close($ch);

    // Decode the response
    $responseData = json_decode($response, true);

    // Check if the response was successful
    if (isset($responseData['success']) && $responseData['success'] === true) {
        return response()->json([
            'success' => true,
            'data' => $responseData
        ]);
    }

    // Return error if the API call fails
    return response()->json([
        'success' => false,
        'error' => $responseData['message'] ?? 'Failed to create invoice'
    ], 500);
}

private function generateUniqueTransactionId($prefix = 'TXN')
{
    // Get current timestamp with microseconds
    $timestamp = now()->format('YmdHisu');
    
    // Generate a random component (8 characters)
    $random = strtoupper(Str::random(8));
    
    // Optional: Include a server identifier if you have multiple servers
    $serverId = env('SERVER_ID', '01');
    
    // Combine all parts with separators for readability
    $transactionId = "{$prefix}-{$timestamp}-{$random}-{$serverId}";
    
    return $transactionId;
}

public function ProdCreateInvoice(Request $request)
{
    // Validate the form data with more lenient rules
    $validatedData = $request->validate([
        'customerName' => 'required|string|max:100',
        'customerEmail' => 'required|email|max:100',
        'phoneNumber' => 'required|string|max:20',
        'amount' => 'required|numeric|min:0',
        'serviceId' => 'required',
        'applicationId' => 'required',
        'requestInfo' => 'nullable'
    ]);

    // Set default values for optional fields
    $customerEmail = $validatedData['customerEmail'];
    $phoneNumber = $validatedData['phoneNumber'];

    // Generate unique IDs
    $transactionId = $this->generateUniqueTransactionId('TXN');
    $itemCode = 'PC-0a93da0719';
    $endpoint = env('PAYMENT_URL');
    $secret_key = env('SECRET_KEY');
    $api_version = env('API_VERSION');

    // Prepare the data for the cURL request
    $data = [
        'transactionId' => $transactionId,
        'paymentAccountIdentifier' => 'BSCHOLARZ_RWF',
        'customer' => [
            'email' => $customerEmail,
            'phoneNumber' => $phoneNumber,
            'name' => $validatedData['customerName']
        ],
        'paymentItems' => [
            [
                'unitAmount' => (float) $validatedData['amount'],
                'quantity' => 1,
                'code' => $itemCode
            ]
        ],
        'description' => 'Invoice for ' . $validatedData['customerName'],
        'expiryAt' => now()->addDays(30)->toIso8601String(),
        'language' => 'EN'
    ];

    // cURL setup
    $ch = curl_init($endpoint);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'irembopay-secretKey: ' . $secret_key,
        'X-API-Version: ' . $api_version,
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Execute cURL request and get the response
    $response = curl_exec($ch);

    // Check for errors
    if ($response === false) {
        return response()->json([
            'success' => false,
            'error' => curl_error($ch)
        ], 500);
    }

    // Close the cURL session
    curl_close($ch);

    // Decode the response
    $responseData = json_decode($response, true);

    // Check if the response was successful
    if (isset($responseData['success']) && $responseData['success'] === true) {

        $application_id = Crypt::decryptString($request->applicationId);
        // Update the application status in the database

        Applications::where('app_id', $application_id)
            ->update([
                'transaction_id' => $responseData['data']['transactionId'],
            ]);

        return response()->json([
            'success' => true,
            'data' => $responseData
        ]);
    }

    // Return error if the API call fails
    return response()->json([
        'success' => false,
        'error' => $responseData
    ], 500);
}

    public static function verifySignature(string $secretKey, string $payload, string $signatureHeader): bool
    {
        // Step 1: Extract timestamp and signature
        $elements = explode(',', $signatureHeader);
        $timestamp = null;
        $signatureHash = null;

        foreach ($elements as $element) {
            [$prefix, $value] = explode('=', $element, 2);
            if ($prefix === 't') {
                $timestamp = $value;
            } elseif ($prefix === 's') {
                $signatureHash = $value;
            }
        }

        if (is_null($timestamp) || is_null($signatureHash)) {
            return false;
        }

        // Step 2: Prepare signed payload
        $signedPayload = $timestamp . '#' . $payload;

        // Step 3: Generate expected signature
        $expectedSignature = hash_hmac('sha256', $signedPayload, $secretKey);

        // Step 4: Compare securely
        if (!hash_equals($expectedSignature, $signatureHash)) {
            return false;
        }

        // Step 5: Optionally validate timestamp (5 minutes tolerance)
        $currentTime = round(microtime(true) * 1000); // in milliseconds
        $timestampInt = (int) $timestamp;

        if (abs($currentTime - $timestampInt) > (300 * 1000)) {
            return false;
        }

        return true;
    }


    public function callback(Request $request)
{
    $signatureHeader = $request->header('irembopay-signature');
    $secretKey = env('SECRET_KEY');
    
    // Log the received signature header and payload for debugging
    Log::debug('Callback received', [
        'header' => $signatureHeader,
        'payload' => $request->all()
    ]);

    // Parse the header: "t=...,s=..."
    $timestamp = null;
    $signatureHash = null;

    if (!empty($signatureHeader)) {
        foreach (explode(',', $signatureHeader) as $part) {
            $parts = explode('=', $part, 2);
            if (count($parts) !== 2) {
                continue; // Skip this part if it doesn't have the expected format
            }
            
            [$key, $value] = $parts;
            if (trim($key) === 't') {
                $timestamp = trim($value);
            } elseif (trim($key) === 's') {
                $signatureHash = trim($value);
            }
        }
    } else {
        return response()->json(['message' => 'Signature header missing'], 400);
    }

    if (!$timestamp || !$signatureHash) {
        return response()->json(['message' => 'Invalid signature header'], 400);
    }

    // Combine timestamp and payload
    $signedPayload = $timestamp . '#' . $request->getContent();

    // Generate expected signature
    $expectedSignature = hash_hmac('sha256', $signedPayload, $secretKey);

    // Compare securely
    if (!hash_equals($expectedSignature, $signatureHash)) {
        Log::error('Signature mismatch', [
            'expected' => $expectedSignature,
            'received' => $signatureHash
        ]);
        return response()->json(['message' => 'Signature mismatch'], 403);
    }

    // Optional: Check if the timestamp is too old (>5 minutes)
    $currentMillis = round(microtime(true) * 1000);
    if (abs($currentMillis - (int)$timestamp) > 5 * 60 * 1000) {
        return response()->json(['message' => 'Signature timestamp expired'], 403);
    }

    // Extract the data from the payload
    $payload = $request->json()->all();
    
    if (!isset($payload['data']) || !isset($payload['data']['transactionId'])) {
        Log::error('Missing transaction data in callback', ['payload' => $payload]);
        return response()->json(['message' => 'Invalid callback data format'], 400);
    }
    
    $transactionId = $payload['data']['transactionId'];
    $paymentStatus = $payload['data']['paymentStatus'] ?? 'UNKNOWN';
    $paymentMethod = $payload['data']['paymentMethod'] ?? 'UNKNOWN';
    $amount = $payload['data']['amount'] ?? 0;
    
    // Only update if payment status is PAID
    if ($paymentStatus === 'PAID') {
        try {
            // Update the application record
            $updated = Applications::where('transaction_id', $transactionId)
                ->update([
                    'payment_status' => 'Paid',
                    'amount_paid' => $amount,
                    'payment_date' => now()
                ]);
            
            if ($updated) {
                Log::info('✅ Payment marked as paid', [
                    'transactionId' => $transactionId,
                    'amount' => $amount
                ]);
            } else {
                Log::warning('⚠️ No application found with transaction ID', [
                    'transactionId' => $transactionId
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update application payment status', [
                'transactionId' => $transactionId,
                'error' => $e->getMessage()
            ]);
            return response()->json(['message' => 'Error updating application record'], 500);
        }
    } else {
        Log::info('Payment not marked as PAID', [
            'transactionId' => $transactionId,
            'status' => $paymentStatus
        ]);
    }

    // Return success regardless if we found the application or not
    // (to avoid giving away information to potential attackers)
    return response()->json(['message' => 'Callback processed successfully'], 200);
}

    /**
 * Generate a signature for IremboPay webhook validation
 *
 * @param array $payload The payload to be sent to the webhook
 * @param string|null $secretKey The secret key for signing (defaults to env value if not provided)
 * @param int|null $timestamp Custom timestamp in milliseconds (defaults to current time if not provided)
 * @return array Returns an array with the timestamp, signature, and formatted header string
 */
function generateIremboPaySignature(array $payload, ?string $secretKey = null, ?int $timestamp = null): array
{
    // Use provided secret key or fetch from environment
    $secretKey = $secretKey ?? env('SECRET_KEY');
    
    if (empty($secretKey)) {
        throw new \InvalidArgumentException('Secret key is required for signature generation');
    }
    
    // Use provided timestamp or generate current time in milliseconds
    $timestamp = $timestamp ?? round(microtime(true) * 1000);
    
    // Convert payload to JSON
    $payloadJson = json_encode($payload);
    
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new \InvalidArgumentException('Invalid payload: ' . json_last_error_msg());
    }
    
    // Create the signed payload (timestamp + '#' + request body)
    $signedPayload = $timestamp . '#' . $payloadJson;
    
    // Generate the HMAC-SHA256 signature
    $signature = hash_hmac('sha256', $signedPayload, $secretKey);
    
    // Format the signature header
    $signatureHeader = "t={$timestamp},s={$signature}";
    
    return [
        'timestamp' => $timestamp,
        'signature' => $signature,
        'header' => $signatureHeader,
        'payload' => $payloadJson
    ];
}

/**
 * Send a signed request to the IremboPay webhook endpoint
 *
 * @param string $url The webhook URL to send the request to
 * @param array $payload The payload to send
 * @param string|null $secretKey Secret key for signing
 * @return \Illuminate\Http\Client\Response
 */
    function sendSignedIremboPayRequest(string $url, array $payload, ?string $secretKey = null)
    {
        $signature = $this->generateIremboPaySignature($payload, $secretKey);
        
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'irembopay-signature' => $signature['header']
        ])->post($url, $payload);
    }
    
public function paymentConfirmation(Request $request)
{
    $transactionId = $request->input('transactionId');
    $status = $request->input('status');
    $amount = $request->input('amount');
    $invoiceNumber = $request->input('invoiceNumber');

    // Log the specific variables
    Log::info('Payment Confirmation Details', [
        'Transaction ID' => $transactionId,
        'Status' => $status,
        'Amount' => $amount,
        'Invoice Number' => $invoiceNumber
    ]);

    // Perform any necessary processing
    return response()->json([
        'success' => true,
        'message' => 'Payment confirmation received',
        'processedTransactionId' => $transactionId
    ]);
}

}
