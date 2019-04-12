<?php
use PHPUnit\Framework\TestCase;
use Franky\Form\Form;

class FormTest extends TestCase
{
    public function testGet()
    {
          $Form = new Form();
        
          $this->assertSame('test','test');
          return $data;
    }
}
