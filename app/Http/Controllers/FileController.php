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

        return view('index')->with([
            'fileName' => $fileName,
            'fileSize' => $fileSize,
            'fileExtension' => $fileExtension,
            'fileNameHashed' => $fileNameHashed
        ]);
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
        $encrypted = $this->encryptFile("uploads/encrypted/$file");

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
        $decryption = $this->decryptFile("uploads/encrypted/$file");

        //download file after decrypted
        return response()->streamDownload(function () use ($decryption) {
            echo $decryption;
        }, $file);
    }

    private function encryptFile($path)
    {
        // cipher method
        $method = 'AES-256-CBC';
        $options = 0;

        // Random Vector for encryption
        $iv = openssl_random_pseudo_bytes(16);

        // encryption key
        $key = openssl_random_pseudo_bytes(32);

        //function to encrypt the data
        $encryption =  openssl_encrypt(
            file_get_contents(url($path)),
            $method,
            $key,
            $options,
            $iv
        );

        return $encryption;
    }
    private function decryptFile($path)
    {

        // cipher method
        $method = 'AES-256-CBC';
        $options = 0;

        // Random Vector for encryption
        $iv = openssl_random_pseudo_bytes(16);

        // encryption key
        $key = openssl_random_pseudo_bytes(32);

        //function to encrypt the data
        $encryption = openssl_encrypt(
            file_get_contents(url($path)),
            $method,
            $key,
            $options,
            $iv
        );

        //function to decrypt the data
        return openssl_decrypt(
            $encryption,
            $method,
            $key,
            $options,
            $iv
        );
    }
}
