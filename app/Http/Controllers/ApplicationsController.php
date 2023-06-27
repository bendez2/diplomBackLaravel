<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use App\Models\Applications;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\Exception\Exception;
use PhpOffice\PhpWord\TemplateProcessor;

class ApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = DB::table('applications')
            ->leftJoin('type_applications', 'applications.type_id', '=', 'type_applications.id')
            ->leftJoin('statuses', 'applications.status_id', '=', 'statuses.id')
            ->leftJoin('name_applications', 'type_applications.nameapplications_id', '=', 'name_applications.id')
            ->leftJoin('priorities', 'type_applications.priorities_id', '=', 'priorities.id')
            ->leftJoin('users', 'applications.initiator_id', '=', 'users.id')
            ->leftJoin('users as employee', 'applications.employee_id', '=', 'employee.id')
            ->select(
                'applications.*',
                'statuses.name as statusName',
                'name_applications.name as nameApplication',
                'name_applications.id as nameIdApplication',
                'priorities.name as namePriority',
                'priorities.id as nameIdPriority',
                'type_applications.sla as sla',
                'users.name as initiatorName',
                'employee.name as employeeName'
            )
            ->get();

        return $results;


        //return DB::table('applications')->get();
        //$result = ApplicationResource::collection(DB::table('applications')->get());
        //return  ApplicationResource::collection(Applications::all());
    }

    public function userApplications($id)
    {
        $results = DB::table('applications')
            ->leftJoin('type_applications', 'applications.type_id', '=', 'type_applications.id')
            ->leftJoin('statuses', 'applications.status_id', '=', 'statuses.id')
            ->leftJoin('name_applications', 'type_applications.nameapplications_id', '=', 'name_applications.id')
            ->leftJoin('priorities', 'type_applications.priorities_id', '=', 'priorities.id')
            ->leftJoin('users', 'applications.initiator_id', '=', 'users.id')
            ->leftJoin('users as employee', 'applications.employee_id', '=', 'employee.id')
            ->where('initiator_id','=', $id)
            ->select(
                'applications.*',
                'statuses.name as statusName',
                'name_applications.name as nameApplication',
                'name_applications.id as nameIdApplication',
                'priorities.name as namePriority',
                'priorities.id as nameIdPriority',
                'type_applications.sla as sla',
                'users.name as initiatorName',
                'employee.name as employeeName'
            )
            ->get();

        return $results;


        //return DB::table('applications')->get();
        //$result = ApplicationResource::collection(DB::table('applications')->get());
        //return  ApplicationResource::collection(Applications::all());
    }
    public function indexInJob($id)
    {
        $results = DB::table('applications')
            ->leftJoin('type_applications', 'applications.type_id', '=', 'type_applications.id')
            ->leftJoin('statuses', 'applications.status_id', '=', 'statuses.id')
            ->leftJoin('name_applications', 'type_applications.nameapplications_id', '=', 'name_applications.id')
            ->leftJoin('priorities', 'type_applications.priorities_id', '=', 'priorities.id')
            ->leftJoin('users', 'applications.initiator_id', '=', 'users.id')
            ->where('applications.employee_id', '=', $id)
            ->Orwhere('applications.employee_id', '=', null)
            ->select(
                'applications.*',
                'statuses.name as statusName',
                'name_applications.name as nameApplication',
                'name_applications.id as nameIdApplication',
                'priorities.name as namePriority',
                'priorities.id as nameIdPriority',
                'type_applications.sla as sla',
                'users.name as initiatorName'
            )
            ->get();

        return $results;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $p = new Applications();
        $p->location = $request->location;
        $p->initiator_id = $request->initiator_id;
        $p->status_id = $request->status_id;
        $p->text = $request->text;
        $p->type_id = $request->type_id;
        $p->historyexecutor = $request->historyexecutor;
        $p->save();

        return true;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Applications $applications)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request): bool
    {
        $app = Applications::find($request->id);

        $app->location = $request->location;
        $app->initiator_id = $request->initiator_id;
        $app->status_id = $request->status_id;
        $app->text = $request->text;
        $app->type_id = $request->type_id;
        $app->historyexecutor = $request->historyexecutor;

        $app->save();

        return true;
    }

    public function acceptApp(Request $request)
    {
        $app = Applications::find($request->id);
        $app->updated_at = Carbon::now();
        $app->employee_id = $request->employee_id;
        $app->status_id = 1;
        $app->save();

        return true;
    }

    public function rejection(Request $request)
    {
        $app = Applications::find($request->id);
        $app->closetime = date('m/d/Y h:i:s', time());
        $app->status_id = 2;
        $app->updated_at = Carbon::now();
        $app->save();

        return true;
    }

    public function complete(Request $request)
    {
        $app = Applications::find($request->id);
        $app->closetime = date('Y-m-d H:i:s', time());
        $diff = $app->created_at->diff($app->closetime);
        $time = ($diff->d . ' дней/дня, ' . $diff->h . ' часов/час, ' . $diff->i . ' минут/минута');
        $app->updated_at = Carbon::now();
        $app->executiontime = $time;
        $app->status_id = 3;

        $app->save();

        return true;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Applications $applications)
    {

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $deleted = DB::table('applications')->delete($id);
    }

    /**
     * @throws Exception
     */
    public function report(Request $request)
    {
        $templateProcessor = new TemplateProcessor('template.docx');
        $applications = DB::table('applications')
            ->leftJoin('type_applications', 'applications.type_id', '=', 'type_applications.id')
            ->leftJoin('statuses', 'applications.status_id', '=', 'statuses.id')
            ->leftJoin('name_applications', 'type_applications.nameapplications_id', '=', 'name_applications.id')
            ->leftJoin('priorities', 'type_applications.priorities_id', '=', 'priorities.id')
            ->leftJoin('users as initiators', 'applications.initiator_id', '=', 'initiators.id')
            ->leftJoin('users as employee', 'applications.employee_id', '=', 'employee.id')
            ->where('applications.created_at', '>', $request->startDate)
            ->where('applications.created_at', '<', $request->endDate)
            ->select('applications.*',
                'statuses.name as statusName',
                'name_applications.name as nameApplication',
                'name_applications.id as nameIdApplication',
                'priorities.name as namePriority',
                'priorities.id as nameIdPriority',
                'type_applications.sla as sla',
                'initiators.name as initiatorName',
                'employee.name as employeeName'
            )->get();
        $templateProcessor->cloneRow('id', count($applications));
        $i = 1;
        foreach ($applications as $result) {
            $templateProcessor->setValue('id#' . $i, $result->id);
            $templateProcessor->setValue('nameApplication#' . $i, $result->nameApplication);
            $templateProcessor->setValue('namePriority#' . $i, $result->namePriority);
            $templateProcessor->setValue('created_at#' . $i, $result->created_at);
            $templateProcessor->setValue('closetime#' . $i, $result->closetime);
            $templateProcessor->setValue('sla#' . $i, $result->sla);
            $templateProcessor->setValue('executiontime#' . $i, $result->executiontime);
            $templateProcessor->setValue('initiatorName#' . $i, $result->initiatorName);
            $templateProcessor->setValue('employeeName#' . $i, $result->employeeName);
            $i++;
        }
        $templateProcessor->setValue('startDate', $request->startDate);
        $templateProcessor->setValue('endDate', $request->endDate);
        $templateProcessor->saveAs('report' . '.docx');
        return response()->download('report' . '.docx')->deleteFileAfterSend(true);
    }

    public function jsonGET(Request $request)
    {

        $applications = DB::table('applications')
            ->leftJoin('type_applications', 'applications.type_id', '=', 'type_applications.id')
            ->leftJoin('statuses', 'applications.status_id', '=', 'statuses.id')
            ->leftJoin('name_applications', 'type_applications.nameapplications_id', '=', 'name_applications.id')
            ->leftJoin('priorities', 'type_applications.priorities_id', '=', 'priorities.id')
            ->leftJoin('users as initiators', 'applications.initiator_id', '=', 'initiators.id')
            ->leftJoin('users as employee', 'applications.employee_id', '=', 'employee.id')
            ->where('applications.created_at', '>', $request->startDate)
            ->where('applications.created_at', '<', $request->endDate)
            ->select(
                'applications.*',
                'statuses.name as statusName',
                'name_applications.name as nameApplication',
                'name_applications.id as nameIdApplication',
                'priorities.name as namePriority',
                'priorities.id as nameIdPriority',
                'type_applications.sla as sla',
                'initiators.name as initiatorName',
                'employee.name as employeeName'
            )
            ->get();

        file_put_contents("export.json", $applications->toJSON(JSON_UNESCAPED_UNICODE));
        return response()->download('export' . '.json')->deleteFileAfterSend(true);
    }

    public function csvGET(Request $request)
    {
        $applications = DB::table('applications')
            ->leftJoin('type_applications', 'applications.type_id', '=', 'type_applications.id')
            ->leftJoin('statuses', 'applications.status_id', '=', 'statuses.id')
            ->leftJoin('name_applications', 'type_applications.nameapplications_id', '=', 'name_applications.id')
            ->leftJoin('priorities', 'type_applications.priorities_id', '=', 'priorities.id')
            ->leftJoin('users as initiators', 'applications.initiator_id', '=', 'initiators.id')
            ->leftJoin('users as employee', 'applications.employee_id', '=', 'employee.id')
            ->where('applications.created_at', '>', $request->startDate)
            ->where('applications.created_at', '<', $request->endDate)
            ->select('applications.*',
                'statuses.name as statusName',
                'name_applications.name as nameApplication',
                'name_applications.id as nameIdApplication',
                'priorities.name as namePriority',
                'priorities.id as nameIdPriority',
                'type_applications.sla as sla',
                'initiators.name as initiatorName',
                'employee.name as employeeName'
            )
            ->get();

        $headers = array(
            'Content-type: text/csv; charset=UTF-8'
        );

        $filepath = public_path('/export.csv');
        $file = fopen($filepath, 'w');

        foreach ($applications as $row) {
            fputcsv($file, [$row->id,
                $row->nameApplication,
                $row->namePriority,
                $row->created_at,
                $row->closetime,
                $row->sla,
                $row->executiontime,
                $row->initiatorName,
                $row->employeeName,
            ]);
        }

        fclose($file);

        return response()->download($filepath,"Экспорт в формате CSV.csv", $headers);
    }

    public function julia(){
        DB::insert('insert into newtable (name,dates) values (?,?)', ["зашла", Carbon::now()->addHours(5)]);
    }
    public function juliaTry(){
        DB::insert('insert into newtable (name,dates) values (?,?)', ["попробовала", Carbon::now()->addHours(5)]);
    }
    public function juliaOpenMobile(){
        DB::insert('insert into newtable (name,dates) values (?,?)', ["зашла на сайт с телефона", Carbon::now()->addHours(5)]);
    }

    public function juliaOpenPc(){
        DB::insert('insert into newtable (name,dates) values (?,?)', ["зашла на сайт с пк", Carbon::now()->addHours(5)]);
    }
}

