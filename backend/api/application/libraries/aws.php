<?php

require 'aws/aws-autoloader.php';

use Aws\S3\S3Client;
use Aws\Ses\SesClient;

class Aws {

    //http://codeigniter-blog.de/100/loading-config-file-in-library-or-model/
    private $CI;

    function __construct() {
        $this->CI = & get_instance();
    }

    function uploadfile($keyname, $filepath, $bucketname) {

        $aws_key = $this->CI->config->item('aws_key');
        $aws_secret = $this->CI->config->item('aws_secret');
        $s3Client = S3Client::factory(array(
                    'key' => $aws_key,
                    'secret' => $aws_secret
        ));
        //http://stackoverflow.com/questions/13464684/how-to-upload-pic-to-amazon-s3-bucket-and-subfolder-and-display-using-php-foreac
        $result = $s3Client->putObject(array(
            'Bucket' => $bucketname,
            'Key' => $keyname,
            'SourceFile' => $filepath,
            'ACL' => 'public-read',
            'StorageClass' => 'REDUCED_REDUNDANCY'
        ));

        //return $result['ObjectURL'];
    }

    //http://stackoverflow.com/questions/189368/creating-an-image-without-storing-it-as-a-local-file
    //http://blogs.aws.amazon.com/php/post/TxKV69TBGSONBU/Amazon-S3-PHP-Stream-Wrapper
    function uploadstream($keyname, $filedata, $bucketname, $filetype = "jpg") {
        $filedatacontent = "";
        $context = "";
        $aws_key = $this->CI->config->item('aws_key');
        $aws_secret = $this->CI->config->item('aws_secret');
        $s3Client = S3Client::factory(array(
                    'key' => $aws_key,
                    'secret' => $aws_secret
        ));
        $s3Client->registerStreamWrapper();

        if ($filetype == "jpg") {
            // Capture image stream in output buffer
            ob_start();
            //imagejpeg($imageRes);
            imagejpeg($filedata);
            $filedatacontent = ob_get_contents();
            ob_end_clean();
            $context = stream_context_create(
                    array(
                        's3' => array(
                            'ContentType' => 'image/jpeg',
                            'ACL' => 'public-read',
                            'StorageClass' => 'REDUCED_REDUNDANCY'
                        )
                    )
            );
        } else if ($filetype == "pdf") {
            $filedatacontent = $filedata;
            $context = stream_context_create(
                    array(
                        's3' => array(
                            'ContentType' => 'application/pdf',
                            'ACL' => 'public-read',
                            'StorageClass' => 'REDUCED_REDUNDANCY'
                        )
                    )
            );
        }
        $s3Stream = fopen('s3://' . $bucketname . '/' . $keyname, 'w', false, $context);
        fwrite($s3Stream, $filedatacontent);
        fclose($s3Stream);
        unset($context, $filedatacontent, $s3Stream);
    }

    //http://docs.aws.amazon.com/AmazonS3/latest/dev/CopyingObjectUsingPHP.html
    function copyfile($keyname, $copyfilepath, $bucketname) {

        $aws_key = $this->CI->config->item('aws_key');
        $aws_secret = $this->CI->config->item('aws_secret');
        $s3Client = S3Client::factory(array(
                    'key' => $aws_key,
                    'secret' => $aws_secret
        ));

        $s3Client->copyObject(array(
            'Bucket' => $bucketname,
            'Key' => $keyname,
            'CopySource' => $copyfilepath,
            'ACL' => 'public-read',
            'StorageClass' => 'REDUCED_REDUNDANCY'
        ));
    }

    function deletefile($keyname, $bucketname) {

        $aws_key = $this->CI->config->item('aws_key');
        $aws_secret = $this->CI->config->item('aws_secret');
        $s3Client = S3Client::factory(array(
                    'key' => $aws_key,
                    'secret' => $aws_secret
        ));

        $s3Client->deleteObject(array(
            'Bucket' => $bucketname,
            'Key' => $keyname,
        ));
    }

    function create_folder($bucketname, $folder_name) {
        $aws_key = $this->CI->config->item('aws_key');
        $aws_secret = $this->CI->config->item('aws_secret');

        $s3Client = S3Client::factory(array(
                    'key' => $aws_key,
                    'secret' => $aws_secret
        ));

        $result = $s3Client->putObject(array(
            'Bucket' => $bucketname,
            'Key' => $folder_name,
            'Body' => '',
        ));
    }

    function check_folder_exits($bucketname, $folder_name) {

        $aws_key = $this->CI->config->item('aws_key');
        $aws_secret = $this->CI->config->item('aws_secret');

        $s3Client = S3Client::factory(array(
                    'key' => $aws_key,
                    'secret' => $aws_secret
        ));

        $response = $s3Client->doesObjectExist($bucketname, $folder_name);

        return $response;
    }

    function sendmail($from_mail, $to_mail, $subject, $message) {

        $aws_key = $this->CI->config->item('aws_key');
        $aws_secret = $this->CI->config->item('aws_secret');
        $aws_region = $this->CI->config->item('aws_region');

        $s3Client = SesClient::factory(array(
                    'key' => $aws_key,
                    'secret' => $aws_secret,
                    'region' => $aws_region
        ));

        $s3Client->sendEmail(array(
            'Source' => $from_mail,
            'Destination' => array(
                'ToAddresses' => array($to_mail)
            ),
            'Message' => array(
                // Subject is required
                'Subject' => array(
                    // Data is required
                    'Data' => $subject
                ),
                'Body' => array(
                    'Html' => array(
                        // Data is required
                        'Data' => $message,
                        'Charset' => 'UTF-8'
                    )
                ),
                'ReplyToAddresses' => array($from_mail)
            )
        ));
    }

    function sendRawmail($from_mail, $to_mail, $subject, $bodymessage, $attachment) {

        $aws_key = $this->CI->config->item('aws_key');
        $aws_secret = $this->CI->config->item('aws_secret');
        $aws_region = $this->CI->config->item('aws_region');

        $s3Client = SesClient::factory(array(
                    'key' => $aws_key,
                    'secret' => $aws_secret,
                    'region' => $aws_region
        ));
        
        $message = "";
        $message.= "Subject: {$subject}\n";
        $message.= "MIME-Version: 1.0\n";
        $message.= 'Content-Type: multipart/mixed; boundary="aRandomString_with_signs_or_9879497q8w7r8number"';
        $message.= "\n\n";
        $message.= "--aRandomString_with_signs_or_9879497q8w7r8number\n";
        $message.= 'Content-Type: text/html; charset="utf-8"';
        $message.= "\n";
        $message.= "Content-Transfer-Encoding: 7bit\n";
        $message.= "Content-Disposition: inline\n";
        $message.= "\n";
        $message.= $bodymessage . "\n";
        foreach ($attachment as $file) {
            $content_id = $this->CI->util->get_rand(20);        
            $file_name = basename($file);
            $entension = ltrim($this->CI->util->get_extension($file_name),".");
            
            $mine_array = array(
                'doc'	=>	'application/msword',
                'ppt'	=>      'application/vnd.ms-powerpoint',
                'zip'	=>	'application/zip',
                'pdf'	=>	'application/pdf',
                'gif'	=>	'image/gif',
                'jpeg'	=>	'image/jpeg',
                'jpg'	=>	'image/jpeg',
                'jpe'	=>	'image/jpeg',
                'png'	=>	'image/png'			
            );
            $entension = ltrim($this->CI->util->get_extension($file_name),".");
            $mine_type = $mine_array[$entension];
            
            $message.= "\n\n";
            $message.= "--aRandomString_with_signs_or_9879497q8w7r8number\n";
            $message.= "Content-ID: \<{$content_id}\>\n";
            $message.= 'Content-Type: '.$mine_type.'; name="'.$file_name.'"';
            $message.= "\n";
            $message.= "Content-Transfer-Encoding: base64\n";
            $message.= 'Content-Disposition: attachment; filename="'.$file_name.'"';
            $message.= "\n";
            $message.= base64_encode(file_get_contents($file));
            $message.= "\n";          
        }
        $message.= "--aRandomString_with_signs_or_9879497q8w7r8number--\n";
        //echo $message;exit;
        $response = $s3Client->sendRawEmail(array(
            'Source' => 'nakkeeran@blisslogix.net',
            'Destinations' => array('nakkeeran.blisslogix@gmail.com'),
            // RawMessage is required
            'RawMessage' => array(
                // Data is required
                'Data' => base64_encode($message),
            ),
        ));
        
        unset($message);
       // var_dump($response);    
    }

}
?>

