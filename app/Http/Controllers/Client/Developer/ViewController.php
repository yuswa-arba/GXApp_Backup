<?php

namespace App\Http\Controllers\Client\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(['role:developer']);
    }

    public function index()
    {
        return view('pages.developer.main');
    }

    public function face()
    {
        return view('pages.developer.face');
    }

    public function logs()
    {
        return view('pages.developer.logs');
    }

    public function queueJob()
    {
        return view('pages.developer.queueJobs');
    }

    public function backup()
    {
        if (!count(config('backup.backup.destination.disks'))) {
            dd(trans('backpack::backup.no_disks_configured'));
        }

        $this->data['backups'] = [];

        foreach (config('backup.backup.destination.disks') as $disk_name) {
            $disk = Storage::disk($disk_name);
            $adapter = $disk->getDriver()->getAdapter();
            $files = $disk->allFiles();

            // make an array of backup files, with their filesize and creation date
            foreach ($files as $k => $f) {
                // only take the zip files into account
                if (substr($f, -4) == '.zip' && $disk->exists($f)) {
                    $this->data['backups'][] = [
                        'file_path'     => $f,
                        'file_name'     => str_replace('backups/', '', $f),
                        'file_size'     => $disk->size($f),
                        'last_modified' => $disk->lastModified($f),
                        'disk'          => $disk_name,
                        'download'      => ($adapter instanceof Local) ? true : false,
                    ];
                }
            }
        }

        // reverse the backups, so the newest one would be on top
        $this->data['backups'] = array_reverse($this->data['backups']);
        $this->data['title'] = 'Backups';

        //return view('backupmanager::backup', $this->data); Data dafault
        return view('pages.developer.backup', $this->data);
    }
    
    public function test()
    {
        return view('pages.developer.test');
    }
}
