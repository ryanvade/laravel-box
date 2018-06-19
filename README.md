[![StyleCI](https://styleci.io/repos/90668280/shield?branch=develop)](https://styleci.io/repos/90668280)

# Laravel BOX

## Get a LaravelBox instance
```php
use LaravelBox\LaravelBox;

$box = LaravelBox("YOUR_API_KEY");
```

## File Commands

### Copy A File
```php
$box->files()->copy("/from/path", "/to/path");
```

### Delete A File
```php
$box->files()->delete("/full/path");
```

### Download A File
```php
$box->files()->download("/remote/path", "/local/path");
```

### Get File Collaborations
```php
$collaborations = $box->files()->collaborations("/remote/path");
```

### Get File Comments
```php
$comments = $box->files()->comments("/remote/path");
```

### Get File Embed Link
```php
$link = $box->files()->embedlink("/remote/path");
```

### Get File Tasks
```php
$tasks = $box->files()->tasks("/remote/path");
```

### Get File Thumbnail
```php
$thumbnail = $box->files()->thumbnail("/remote/path");
```

### Get File Information
```php
$information = $box->files()->information("/remote/path");
```

### Lock File
```php
$isLocked = $box->files()->lock("/remote/path");
```

### Move File
```php
$box->files()->move("/from/path", "/to/path");
```

### Preflight Check File
```php
$okay = $box->files()->preflightCheck("/local/path", "/remote/path");
```

### Unlock File
```php
$isLocked = $box->files()->unlock("/remote/path");
```

### Upload File
```php
$box->files()->upload("/local/path", "/remote/path");
```

### Upload File Version
```php
$box->files()->uploadVersion("/local/path", "/remote/path");
```
