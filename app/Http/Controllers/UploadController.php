<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
// use Storage;
use Google\Cloud\Storage\StorageClient;
use App\Models\CompetitionJoinCategory;
use App\Models\CompetitionJoinPayment;
class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $id=$request->id;
        $competition=CompetitionJoinCategory::where('id',$id)->with('member','categories','competition_join.competition')->first();
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
        // file not uploaded
        }

        $fileReceived = $receiver->receive();

        if ($fileReceived->isFinished()) {
            $file = $fileReceived->getFile();
            $extension = $file->getClientOriginalExtension();
            $fileName = $competition->competition_join->competition->title.'/video/'.$competition->categories->name.'/'.$competition->member->username . $this->generate_transaction_number() . '.' . $extension;

            $projectId = env('GOOGLE_CLOUD_PROJECT_ID');
            $keyFilePath = storage_path(env('GOOGLE_CLOUD_KEY_FILE'));
            $bucketName = env('GOOGLE_CLOUD_STORAGE_BUCKET');

            $storage = new StorageClient([
                'projectId' => $projectId,
                'keyFilePath' => $keyFilePath,
            ]);
            $bucket = $storage->bucket($bucketName);

            $options = [
                'name' => $fileName,
                'predefinedAcl' => 'publicRead',
            ];

            $fileContents = file_get_contents($file->getPathname());

            $object = $bucket->upload($fileContents, $options);

            $fileUrl = "https://storage.googleapis.com/{$bucketName}/{$fileName}";

        // Delete chunked file
            unlink($file->getPathname());

            return [
                'path' => $fileUrl,
                'filename' => $fileName,
            ];
        }

        $handler = $fileReceived->handler();
        return [
            'done' => $handler->getPercentageDone(),
            'status' => true,
        ];
    }


    public function generate_transaction_number()
    {
        $year = date('Y'); 
        $month = date('m'); 
        $sequence = CompetitionJoinPayment::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->count() + 1;

        $sequence_padded = str_pad($sequence, 2, '0', STR_PAD_LEFT);

        $transaction_number = $year . $month . $sequence_padded;
        return $transaction_number;
    }

}
