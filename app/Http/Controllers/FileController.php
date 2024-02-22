<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EncryptedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\Shared\Html;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'file' => 'required|mimes:docx|max:2048',
            ]);

            // Get the uploaded file
            $file = $request->file('file');
            Log::info(' Content: ' . $file);

            $phpWord = IOFactory::load($file);
            $content = '';

            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getElements')) {
                        foreach ($element->getElements() as $childElement) {
                            if (method_exists($childElement, 'getText')) {
                                $content .= $childElement->getText() . ' ';
                            } else if (method_exists($childElement, 'getContent')) {
                                $content .= $childElement->getContent() . ' ';
                            }
                        }
                    } else if (method_exists($element, 'getText')) {
                        $content .= $element->getText() . ' ';
                    }
                }
            }
            Log::info(' Content: ' . $content);
            // Encrypt the file content
            $encryptedContent = Crypt::encrypt($content);

            $originalFilename = $file->getClientOriginalName();

            // Add the "encrypted_" prefix to the filename
            $filename = 'encrypted_' . $originalFilename;

            // Create a PHPWord instance and add the encrypted content to the DOCX file
            $phpWord = new PhpWord();
            $section = $phpWord->addSection();
            $section->addText($encryptedContent);

            // Save the DOCX file with the original filename
            $docxFilePath = storage_path('app/' . $filename);
            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($docxFilePath);

            EncryptedFile::create([
                'filename' => $filename,
                'content' => $docxFilePath,
            ]);

            return redirect()->back()->with('success', 'File has been Encrypted and Uploaded Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while processing. Please make sure you uploaded a file or a valid DOCX file.');
        }
    }

    public function download($id)
    {
        $file = EncryptedFile::find($id);
        $docxFilePath = $file->content;

        return response()->download(
            $docxFilePath,
            $file->filename,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ]
        );
    }


    public function index()
    {
        $files = EncryptedFile::all();

        return view('files.index', compact('files'));
    }




    public function decrypt(Request $request)
    {
        $request->validate([
            'decrypt_data' => 'required|exists:encrypted_files,id',
        ]);

        $selectedFileId = $request->input('decrypt_data');
        $selectedFile = EncryptedFile::find($selectedFileId);
        Log::info('sele Content: ' . $selectedFile);
        try {
            $filePath = $selectedFile->content;
            Log::info(' Content: ' . $filePath);

            $phpWord = IOFactory::load($filePath);
            $content = '';

            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getElements')) {
                        foreach ($element->getElements() as $childElement) {
                            if (method_exists($childElement, 'getText')) {
                                $content .= $childElement->getText() . ' ';
                            } else if (method_exists($childElement, 'getContent')) {
                                $content .= $childElement->getContent() . ' ';
                            }
                        }
                    } else if (method_exists($element, 'getText')) {
                        $content .= $element->getText() . ' ';
                    }
                }
            }
            Log::info(' decContent: ' . $content);
            $decryptedContent = Crypt::decrypt($content);


            $originalFilename = $selectedFile->filename;
            $downloadFilename = Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME), '_') . '.docx';
            $originalFilenameWithoutPrefix = preg_replace('/^encrypted_/', '', $originalFilename);
           

            // Create a PHPWord instance and add the decrypted content as plain text to a DOCX file
            $phpWord = new PhpWord();
            $section = $phpWord->addSection();
            $section->addText($decryptedContent);

            // Save the DOCX file to storage
            $docxFilePath = 'decrypted_' . $downloadFilename;
            $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save(storage_path('app/' . $docxFilePath));

            // Return the decrypted file as a download response with the original filename
            return response()->download(
                storage_path('app/' . $docxFilePath),
                'decrypted_' . $originalFilenameWithoutPrefix,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                ]
            )->deleteFileAfterSend(true); // Delete the temporary file after sending it.
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            Log::error('Decryption error: ' . $e->getMessage());
            // Handle decryption errors, such as an invalid key or corrupted data
            return back()->with('error', 'Failed to decrypt data.');
        }
    }


    public function delete($id)
    {
        $file = EncryptedFile::find($id);

        if (!$file) {
            return back()->with('error', 'File not found.');
        }

        // Delete the file record from the database
        $file->delete();

        return back()->with('success', 'File deleted successfully.');
    }
}