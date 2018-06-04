# gdirect
Codeigniter library to get direct download of Google Drive file link

## Usage
### Load Library
```php
$this->load->library('gdirect');
```

### Request a download
```php
// true: redirect download
// false: string output
$this->gdirect->generateLink('DRIVE_ID', false);
```
### Get the File ID
```php
$this->gdirect->get_driveid_from_url('https://drive.google.com/open?id=16NdH7CuNnt4FUkakL7R61D0XptKMoSyC')
// output: 16NdH7CuNnt4FUkakL7R61D0XptKMoSyC
```

[Demo](https://mbn12.herokuapp.com/gdirect/)