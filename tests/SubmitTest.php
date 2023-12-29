<?php


use PHPUnit\Framework\TestCase;

class SubmitTest extends TestCase
{
    public function testValidFormData()
    {
        $formData = [
            "property_name" => "Sample Property",
            "is_for_sale" => "sale",
            "price" => 10000,
            "city" => "Samlpe City",
            "address" => "Sample Address",
            "" => 1,
            "level_number" => 2,
            "rooms" => 3,
            "is_for_sale" => 1,
            "bath_rooms" => 2,
            "rooms" => 3,
            "type" => "Irdoda",
            "property_condition" => "Felújított",
            "has_garage" => 0,
            "pool" => 0,
            "has_wifi" => 0,
            "property_description" => "Sample Description",
            "agent_id" => "Sample Description"

        ];


        $result = validateForm($formData);
        $this->assertTrue($result['isValid']);
        $this->assertEmpty($result['errors']);
    }

    public function testInvalidFormData()
    {
        $formData = [
            "property_name" => "",
            "is_for_sale" => "",
            "price" => -100,
            // ... include other fields with invalid data
        ];

        $result = validateForm($formData);
        $this->assertFalse($result['isValid']);
        $this->assertNotEmpty($result['errors']);
        $this->assertArrayHasKey('property_name', $result['errors']);
        $this->assertArrayHasKey('is_for_sale', $result['errors']);
        $this->assertArrayHasKey('price', $result['errors']);

    }
}
