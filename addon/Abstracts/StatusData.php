<?php

namespace WPMVC\Addons\Status\Abstracts;

/**
 * Abstract class used to display system information.
 *
 * @author 10 Quality Studio <info@10quality.com>
 * @package wpmvc-addon-status
 * @license MIT
 * @version 1.0.0
 */
abstract class StatusData
{
    /**
     * Data attributes.
     * @since 1.0.0
     * 
     * @var array
     */
    protected $attributes = [];
    /**
     * Default constructor.
     * @since 1.0.0
     * 
     * @param array $attributes
     */
    public function __construct( $attributes = [] )
    {
        $this->attributes = $attributes;
    }
    /**
     * Getter.
     * @since 1.0.0
     * 
     * @param string $property
     * 
     * @return mixed
     */
    public function __get( $property )
    {
        return array_key_exists( $property, $this->attributes )
            ? $this->attributes[$property]
            : null;
    }
    /**
     * Setter.
     * @since 1.0.0
     * 
     * @param string $property
     * @param mixed  $value
     */
    public function __set( $property, $value )
    {
        $this->attributes[$property] = $value;
    }
    /**
     * Called by status system controller to check on the system status data that need to be presented.
     * @since 1.0.0
     */
    public function check()
    {
        // @todo on child
    }
    /**
     * Cast data to array.
     * @since 1.0.0
     * 
     * @return array
     */
    public function to_array()
    {
        return [
            'section' => $this->section ? $this->section : 'other',
            'title' => $this->title,
            'message' => $this->message,
            'status' => $this->status && is_numeric( $this->status ) ? intval( $this->status ) : 0,
        ];
    }
    /**
     * Cast data to string.
     * @since 1.0.0
     * 
     * @return array
     */
    public function __toString()
    {
        return json_encode( $this->to_array() );
    }
}