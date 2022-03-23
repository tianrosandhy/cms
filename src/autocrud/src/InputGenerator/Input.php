<?php
namespace TianRosandhy\Autocrud\InputGenerator;

use TianRosandhy\Autocrud\Exceptions\InputException;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Input
{
    public $baseView = 'autocrud::input.';
    public $multiLanguage = false;

    // type constants registration
    public const TYPE_TEXT = 'Text';
    public const TYPE_NUMBER = 'Number';
    public const TYPE_EMAIL = 'Email';
    public const TYPE_TAGS = 'Tags';
    public const TYPE_TEL = 'Tel';
    public const TYPE_DATE = 'Date';
    public const TYPE_DATERANGE = 'DateRange';
    public const TYPE_DATETIME = 'DateTime';
    public const TYPE_COLOR = 'Color';
    public const TYPE_CHECKBOX = 'Checkbox';
    public const TYPE_RADIO = 'Radio';
    public const TYPE_CURRENCY = 'Currency';
    public const TYPE_FILE = 'File';
    public const TYPE_FILEMULTIPLE = 'FileMultiple';
    public const TYPE_IMAGE = 'Image';
    public const TYPE_IMAGEMULTIPLE = 'ImageMultiple';
    public const TYPE_IMAGESIMPLE = 'ImageSimple';
    public const TYPE_MAP = 'Map';
    public const TYPE_PASSWORD = 'Password';
    public const TYPE_RICHTEXT = 'Richtext';
    public const TYPE_SELECT = 'Select';
    public const TYPE_SELECTMULTIPLE = 'SelectMultiple';
    public const TYPE_SLUG = 'Slug';
    public const TYPE_TEXTAREA = 'Textarea';
    public const TYPE_TIME = 'Time';
    public const TYPE_YESNO = 'Yesno';

    public function __construct()
    {
        // all input component will be aliased like below
        $this->mapComponent = [
            self::TYPE_TEXT => Components\Text::class,
            self::TYPE_NUMBER => Components\Number::class,
            self::TYPE_EMAIL => Components\Email::class,
            self::TYPE_TAGS => Components\Tags::class,
            self::TYPE_TEL => Components\Tel::class,
            self::TYPE_DATE => Components\Date::class,
            self::TYPE_DATERANGE => Components\DateRange::class,
            self::TYPE_DATETIME => Components\DateTime::class,
            self::TYPE_COLOR => Components\Color::class,
            self::TYPE_CHECKBOX => Components\Checkbox::class,
            self::TYPE_RADIO => Components\Radio::class,
            self::TYPE_CURRENCY => Components\Currency::class,
            self::TYPE_FILE => Components\File::class,
            self::TYPE_FILEMULTIPLE => Components\FileMultiple::class,
            self::TYPE_IMAGE => Components\Image::class,
            self::TYPE_IMAGEMULTIPLE => Components\ImageMultiple::class,
            self::TYPE_IMAGESIMPLE => Components\ImageSimple::class,
            self::TYPE_MAP => Components\Map::class,
            self::TYPE_PASSWORD => Components\Password::class,
            self::TYPE_RICHTEXT => Components\Richtext::class,
            self::TYPE_SELECT => Components\Select::class,
            self::TYPE_SELECTMULTIPLE => Components\SelectMultiple::class,
            self::TYPE_SLUG => Components\Slug::class,
            self::TYPE_TEXTAREA => Components\Textarea::class,
            self::TYPE_TIME => Components\Time::class,
            self::TYPE_YESNO => Components\Yesno::class,
        ];
    }

    // all input type will call this
    protected function generateInputArgs($name, $config = [])
    {
        if (isset($config['type'])) {
            unset($config['type']); //type parameter will not be needed again now
        }
        return array_merge([
            'name' => $name,
            'multiLanguage' => $this->multiLanguage,
        ], $config);
    }

    public function type($type, $name, $config = [])
    {
        $studlycase = Str::studly($type);
        if (isset($this->mapComponent[$studlycase])) {
            $args = $this->generateInputArgs($name, $config);
            return (new $this->mapComponent[$studlycase](...$args))->htmlRender();
        }

        $camelize = Str::camel($type);
        if (method_exists($this, $camelize)) {
            return $this->{$camelize}($name, $config);
        } else {
            throw new InputException('Input type ' . $type . ' is still not defined');
        }
    }

    public function customComponent(Component $component, $name, $config=[])
    {
        $args = $this->generateInputArgs($name, $config);
        return (new $component(...$args))->htmlRender();
    }

    public function multiLanguage()
    {
        $this->multiLanguage = true;
        return $this;
    }

    protected function mandatoryConfig($config = [], $mandatory = [], $input_type = 'text')
    {
        if (!empty($mandatory)) {
            foreach ($mandatory as $config_key) {
                if (!isset($config[$config_key])) {
                    throw new InputException('Config "' . $config_key . '" is mandatory for input type "' . $input_type . '"');
                }
            }
        }
    }

    public function loadView($view_name, $input_name, $config = [], $fallback = true)
    {
        if (view()->exists($this->baseView . $view_name)) {
            if (!isset($config['name'])) {
                $config['name'] = $input_name;
            }
            if ($this->multiLanguage) {
                $config['multiLanguage'] = true;
            }
            return view($this->baseView . $view_name, $config)->render();
        }

        $msg = 'Input ' . $view_name . ' view is still not defined';
        if ($fallback) {
            return '<div class="alert alert-danger">' . $msg . '</div>';
        }
        throw new InputException($msg);
    }

    public function text($name, $config = [])
    {
        return $this->type('Text', $name, $config);
    }
    public function number($name, $config = [])
    {
        return $this->type('Number', $name, $config);
    }
    public function currency($name, $config = [])
    {
        return $this->type('Currency', $name, $config);
    }
    public function email($name, $config = [])
    {
        return $this->type('Email', $name, $config);
    }
    public function password($name, $config = [])
    {
        return $this->type('Password', $name, $config);
    }
    public function color($name, $config = [])
    {
        return $this->type('Color', $name, $config);
    }
    public function richtext($name, $config = [])
    {
        return $this->type('RichText', $name, $config);
    }
    public function textarea($name, $config = [])
    {
        return $this->type('Textarea', $name, $config);
    }
    public function tel($name, $config = [])
    {
        return $this->type('Tel', $name, $config);
    }
    public function tags($name, $config = [])
    {
        return $this->type('Tags', $name, $config);
    }
    public function image($name, $config = [])
    {
        return $this->type('Image', $name, $config);
    }
    public function imageMultiple($name, $config = [])
    {
        return $this->type('ImageMultiple', $name, $config);
    }
    public function imageSimple($name, $config = [])
    {
        return $this->type('ImageSimple', $name, $config);
    }
    public function slug($name, $config = [])
    {
        return $this->type('Slug', $name, $config);
    }
    public function date($name, $config = [])
    {
        return $this->type('Date', $name, $config);
    }
    public function time($name, $config = [])
    {
        return $this->type('Time', $name, $config);
    }
    public function dateTime($name, $config = [])
    {
        return $this->type('DateTime', $name, $config);
    }
    public function dateRange($name, $config = [])
    {
        return $this->type('DateRange', $name, $config);
    }
    public function file($name, $config = [])
    {
        return $this->type('File', $name, $config);
    }
    public function fileMultiple($name, $config = [])
    {
        return $this->type('FileMultiple', $name, $config);
    }
    public function select($name, $config = [])
    {
        return $this->type('Select', $name, $config);
    }
    public function selectMultiple($name, $config = [])
    {
        return $this->type('SelectMultiple', $name, $config);
    }
    public function radio($name, $config = [])
    {
        return $this->type('Radio', $name, $config);
    }
    public function checkbox($name, $config = [])
    {
        return $this->type('Checkbox', $name, $config);
    }
    public function yesno($name, $config = [])
    {
        return $this->type('Yesno', $name, $config);
    }
    public function map($name, $config = [])
    {
        return $this->type('Map', $name, $config);
    }

    // will generate a custom view input type
    public function view($name, $config = [])
    {
        $this->mandatoryConfig($config, ['view_source', 'data'], 'view');
        return $this->loadView('view', $name, $config);
    }

}
