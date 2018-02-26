<?php

namespace App\Http\Controllers\BackendV1\Helpdesk\Developer;


use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Adapter\Local;


class BackupController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:developer']);
    }

    public function create()
    {
        try {
//            ini_set('max_execution_time', 300);

            //TODO : Consider to call this using Job & Queue

            // start the backup process
            Artisan::call('backup:run',['--disable-notifications'=>'']);
            $output = Artisan::output();

            // return the results as a response to the ajax call
            echo json_encode($output);

        } catch (Exception $e) {

            echo json_encode($e->getMessage());
        }

        return 'Success';
    }

    /**
     * Downloads a backup zip file.
     */
    public function download(Request $request)
    {
        $disk = Storage::disk($request->get('disk'));
        $file_name = $request->get('file_name');
        $adapter = $disk->getDriver()->getAdapter();

        if ($adapter instanceof Local) {
            $storage_path = $disk->getDriver()->getAdapter()->getPathPrefix();

            if ($disk->exists($file_name)) {
                return response()->download($storage_path.$file_name);
            } else {
                abort(404, trans('backpack::backup.backup_doesnt_exist'));
            }
        } else {
            abort(404, trans('backpack::backup.only_local_downloads_supported'));
        }
    }

    /**
     * Deletes a backup file.
     */
    public function delete(Request $request,$file_name)
    {
        $disk = Storage::disk($request->get('disk'));

        if ($disk->exists($file_name)) {
            $disk->delete($file_name);

            return 'success';
        } else {
            abort(404, trans('backpack::backup.backup_doesnt_exist'));
        }
    }
}
