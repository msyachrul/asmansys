<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CertificateOnAsset extends Model
{
    public function certificate()
    {
    	return $this->belongsTo(Certificate::class);
    }
}
