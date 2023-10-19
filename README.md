# Usage Instructions for Image Uploader

## Installation

```
composer require stew/image-uploader
```

## Usage

- Step 1: Import the UploaderTrait

```angular2html
use Stew\ImageUploader\Traits\UploaderTrait;
```

- Step 2: Implement the Trait in Your Class/Controller

```angular2html
use Stew\ImageUploader\Traits\UploaderTrait;

class YourController extends Controller
{
    use UploaderTrait;

    public function uploadImage(Request $request)
    {
        // code
    }
}
```

## Utilize the Provided Methods

 #### Get Image Disk

- The getImageDisk() method retrieves the name of the image storage disk. By default, it reads the FILESYSTEM_DISK environment variable. You can specify a different disk by setting the FILESYSTEM_DISK variable in your environment configuration.

```angular2html
$this->getImageDisk();
```

- Make sure that your .env file or environment configuration has the FILESYSTEM_DISK variable set to the desired disk, for example:

```angular2html
FILESYSTEM_DISK=local
```

#### Get Storage Directory

 - To obtain the storage directory for images, use the getDirectory($path) method.

```angular2html
$this->getDirectory($path);
```

#### Save Image File to Storage

- This method is used to save an image file to your storage. It returns a string representing the path to the saved image with a .webp extension.

```angular2html
$this->saveFileToStorage($fileName, $path);
```

#### Check for Base64 String

- To check if a string is a base64 string, use the isBase64($strEndcode) method.

```angular2html
$this->isBase64($strEndcode);
```

#### Delete Image

- To delete an image file from storage, utilize the deleteImage($filePath) method.

```angular2html
$this->deleteImage($filePath);
```
