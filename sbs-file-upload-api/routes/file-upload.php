<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\UploadedFile;

$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/uploads';

$app->post('/file-upload', function(Request $request, Response $response) {
    $directory = $this->get('upload_directory');

    $uploadedFiles = $request->getUploadedFiles();

    // handle single input with single file upload
    $uploadedFile = $uploadedFiles['sbs_file'];
    if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
        $filename = moveUploadedFile($directory, $uploadedFile);
		return $response->withStatus(200)->withJson('File '.$filename.' uploaded successfully!');
        // $response->write('uploaded ' . $filename . '<br/>');
    }else{
		return $response->withStatus(200)->withJson('Failed to upload the file!!!');
	}


    // handle multiple inputs with the same key
    foreach ($uploadedFiles['sbs_files'] as $uploadedFile) {
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
			return $response->withStatus(200)->withJson('File '.$filename.' uploaded successfully!');
            // $response->write('uploaded ' . $filename . '<br/>');
        }else{
			return $response->withStatus(200)->withJson('Failed to upload the file!!!');
		}
    }

});

/**
 * Moves the uploaded file to the upload directory and assigns it a unique name
 * to avoid overwriting an existing uploaded file.
 *
 * @param string $directory directory to which the file is moved
 * @param UploadedFile $uploaded file uploaded file to move
 * @return string filename of moved file
 */
function moveUploadedFile($directory, UploadedFile $uploadedFile)
{
    $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
    $basename =  $uploadedFile->getClientFilename(). date("d-m-Y-h-i-sa");//bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
    $filename = sprintf('%s.%s', $basename, $extension);

    $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

    return $filename;
}