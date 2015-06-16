<?php

class Collection extends \Eloquent {

    const ARTWORKS_DIR = '/images/kolekcie/';

    public static $rules = array(
        'name' => 'required',
        'text' => 'required',
        );

    public static $sortable = array(
        'created_at' => 'dátumu vytvorenia',
        'name' => 'názvu',
    );
    
    public function items()
    {
        return $this->belongsToMany('Item', 'collection_item', 'collection_id', 'item_id');
    }

    public function getPreviewItems()
    {
        
        return $this->items()->limit(10)->get();
    }

    public function getUrl()
    {
    	return URL::to('kolekcia/' . $this->attributes['id']);
    }

    public function getShortTextAttribute($string, $length = 160)
    {
        $striped_string = strip_tags(br2nl($string));
        $string = $striped_string;
        $string = substr($string, 0, $length);
        return ($striped_string > $string) ? substr($string, 0, strrpos($string, ' ')) . " ..." : $string;
    }

    public function hasHeaderImage() {
        return file_exists(self::getHeaderImageForId($this->id, true));
    }

    public function getHeaderImage() {
        return self::getHeaderImageForId($this->id);
    }

    public  static function getHeaderImageForId($id, $full = false) {
        $relative_path = self::ARTWORKS_DIR . $id . '.jpg';
        $path = ($full) ? public_path() . $relative_path : $relative_path;
        return $path;
    }

    public function scopePublished($query)
    {
        return $query->where('publish', '=', 1);
    }

    public function getTitleColorAttribute($value) {        
        return (!empty($value)) ? $value : '#fff';
    }

    public function getTitleShadowAttribute($value) {        
        return (!empty($value)) ? $value : '#777';
    }

}
