<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Person extends \Eloquent
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ ];

    protected $connection = 'vapor_age';

    protected $primaryKey = 'cedula_id';

    public function compareNames( $name_1, $name_2, $name_3 )
    {
        $name_1 = trim($name_1);
        $name_2 = trim($name_2);
        $name_3 = trim($name_3);

        $match_1 = false;
        $match_2 = false;
        $match_3 = false;

        if ( $this->compareFirstNames( $name_1 ) )
        {
            $match_1 = true;
        }

        if ( mb_strtolower( $this->name_2 ) == mb_strtolower( $name_2 ) )
        {
            $match_2 = true;
        }

        if ( mb_strtolower( $this->name_3 ) == mb_strtolower( $name_3 ) )
        {
            $match_3 = true;
        }

        return [ "match_1" => $match_1, "match_2" => $match_2, "match_3" => $match_3 ];

    }

    protected function compareFirstNames( $name_1 )
    {
        if ( mb_strtolower( $this->name_1 ) == mb_strtolower( $name_1 ) )
        {
            return true;
        }

        $name_1_names = explode( ' ', $this->name_1 );

        if ( empty( $name_1_names[ 0 ] ) )
        {
            return false;
        }

        if ( mb_strtolower( $name_1_names[ 0 ] ) == mb_strtolower( $name_1 ) )
        {
            return true;
        }

        if ( empty( $name_1_names[ 1 ] ) )
        {
            return false;
        }

        if ( mb_strtolower( $name_1_names[ 1 ] ) == mb_strtolower( $name_1 ) )
        {
            return true;
        }

        return false;
    }
}
