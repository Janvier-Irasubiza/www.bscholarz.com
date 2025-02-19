<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Subscriber;
use App\Models\SubscriberSubscription;
use Illuminate\Console\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use App\Mail\RequestReply;
use App\Models\Discipline;
use App\Models\Advert;
use App\Models\Partner;
use App\Models\Request as Applications;
use Mail;


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

}
