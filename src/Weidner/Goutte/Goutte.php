<?php namespace Weidner\Goutte;

class Goutte {

  /**
   * Factory method. Creates a new goutte client instance.
   *
   * @return  Goutte\Client
   */
  public static function client()
  {
    return new Goutte\Client();
  }

}
