# Usage Instructions for Image Uploader

## Installation

```
composer require stew/image-uploader:dev-feature/dev-test
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

- Make sure that your `.env` file and config `filesystems.default` has the FILESYSTEM_DISK variable, for example:


```angular2html
FILESYSTEM_DISK=local
```


``` angular2html
'default' => env('FILESYSTEM_DISK', 'local'),
```

- To use the database for storing configuration, you need to run a migration with the following command:

```angular2html
php artisan migrate
```

- The above command will create a "settings" table with the following structure:

```angular2html
Schema::create('settings', function (Blueprint $table) {
    $table->id();
    $table->string('key')->unique();
    $table->text('value');
    $table->timestamps();
});
```

- We have provided sample data for you to test. You can seed the sample data with the following command.

```angular2html
php artisan db:seed --class=Stew\\ImageUploader\\Database\\Seeders\\SettingSeeder
```

- To use configuration from the "settings" table (by default), you can use the following function:

```angular2html
$this->getImageDisk('YOUR TABLE') // Default is "settings"
```

- If you want to customize the seeded data, you can use the following command:

```angular2html
php artisan vendor:publish --provider="Stew\ImageUploader\Providers\ImageUploaderServiceProvider"
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

## The Public Disk
- To create the symbolic link, you may use the storage:link Artisan command:

```angular2html
php artisan storage:link
```

## Test

```angular2html
http://localhost:8000/demo
```
