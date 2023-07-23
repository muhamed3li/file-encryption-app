<?php

namespace App\Http\Controllers;

use App\Traits\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    use Upload;

    public function index()
    {
        return view('index');
    }

    public function upload(Request $request)
    {
        $file = $request->file('file');

        //upload file and hashed name 
        $fileNameHashed = $this->uploadFile($file, 'encrypted');

        // Get file details
        $fileName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $fileExtension = $file->getClientOriginalExtension();

        return view('index', compact('fileName', 'fileSize', 'fileExtension', 'fileNameHashed'));
    }

    public function encrypt(Request $request)
    {
        $file = $request->file;

        //check if file exists
        $fileExists = Storage::disk('public')->exists("uploads/encrypted/$file");
        if (!$fileExists) {
            return redirect()->back()->with('error', 'File not exists.');
        }

        // encrypted file content
        $encrypted = encryptFile("uploads/encrypted/$file");

        //download file after encrypted
        return response()->streamDownload(function () use ($encrypted) {
            echo $encrypted;
        }, $file);
    }

    public function decrypt(Request $request)
    {
        $file = $request->file;

        //check if file exists
        $fileExists = Storage::disk('public')->exists("uploads/encrypted/$file");
        if (!$fileExists) {
            return redirect()->back()->with('error', 'File not exists.');
        }

        // decrypted file
        $decryption = decryptFile("uploads/encrypted/$file");

        //download file after decrypted
        return response()->streamDownload(function () use ($decryption) {
            echo $decryption;
        }, $file);
    }
}
