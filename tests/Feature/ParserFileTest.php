<?php

namespace RomaMb\Press\Tests\Feature;

use Carbon\Carbon;
use RomaMb\Press\PressFileParser;
use RomaMb\Press\Tests\TestCase;

class ParserFileTest extends TestCase
{
    /** @test */
    public function should_parser_file(): void
    {
        $dir = __DIR__ . '/../blogs/MK_File1.md';
        $data = (new PressFileParser($dir))->splitFile()->getRawData();
        $this->assertStringContainsString('title: My Title', $data[1]);
        $this->assertStringContainsString('description: Description Here', $data[1]);
        $this->assertStringContainsString('Blog post body here.', $data[2]);
    }

    /** @test */
    public function should_parser_string(): void
    {
        $file = "---\ntitle: My Title\n---\nBlog post body here.";
        $data = (new PressFileParser($file))->splitFile()->getRawData();
        $this->assertStringContainsString('title: My Title', $data[1]);
        $this->assertStringContainsString('Blog post body here.', $data[2]);
    }

    /** @test */
    public function each_head_field_gets_separated(): void
    {
        $dir = __DIR__ . '/../blogs/MK_File1.md';
        $data = (new PressFileParser($dir))
            ->splitFile()
            ->explodeData()
            ->getData();

        $this->assertStringContainsString('My Title', $data['title']);
        $this->assertStringContainsString('Description Here', $data['description']);
    }

    /** @test */
    public function get_the_body_on_the_data(): void
    {
        $dir = __DIR__ . '/../blogs/MK_File1.md';
        $data = (new PressFileParser($dir))
            ->splitFile()
            ->explodeData()
            ->processFields()
            ->getData();

        $this->assertStringContainsString("<h2>Heading</h2>\n<p>Blog post body here.</p>", $data['body']);
    }

    /** @test */
    public function a_date_field_gets_parsed(): void
    {
        $file = "---\ntitle: My Title\ndate: May 04, 1988\n---\nBlog post body here.";
        $data = (new PressFileParser($file))
            ->splitFile()
            ->explodeData()
            ->processFields()
            ->getData();

        $this->assertInstanceOf(Carbon::class, $data['date']);
        $this->assertEquals('05/04/1988', $data['date']->format('m/d/Y'));
    }

    /** @test
     * @throws \JsonException
     */
    public function an_extra_fields_gets_saved(): void
    {
        $file = "---\nauthor: Jhon Doe\n---\n";
        $data = (new PressFileParser($file))
            ->splitFile()
            ->explodeData()
            ->processFields()
            ->getData();

        $this->assertEquals(json_encode(['author' => 'Jhon Doe'], JSON_THROW_ON_ERROR), $data['extra']);
    }

    /**
     * @test
     *
     * @throws \JsonException
     */
    public function two_additional_fields_are_put_into_extra(): void
    {
        $file = "---\nauthor: Jhon Doe\nimage: image.png\n---\n";
        $data = (new PressFileParser($file))
            ->splitFile()
            ->explodeData()
            ->processFields()
            ->getData();

        $this->assertEquals(
            json_encode([
                'author' => 'Jhon Doe',
                'image' => 'image.png',
            ], JSON_THROW_ON_ERROR),
            $data['extra']
        );
    }

    /**
     * @test
     *
     * @throws \JsonException
     */
    public function assert_abstract_field_without_implements(): void
    {
        $file = "---\nFirstName: Jhon\nLastName: Doe\n---\n";
        $data = (new PressFileParser($file))
            ->splitFile()
            ->explodeData()
            ->processFields()
            ->getData();

        $this->assertEquals(
            json_encode([
                'FirstName' => 'Jhon',
                'LastName' => 'Doe',
            ], JSON_THROW_ON_ERROR),
            $data['extra']
        );
    }

    /** @test
     * @throws \JsonException
     */
    public function assert_abstract_title_description_implements(): void
    {
        $file = "---\ntitle: My Title\ndescription: Some Description\n---\n";
        $data = (new PressFileParser($file))
            ->splitFile()
            ->explodeData()
            ->processFields()
            ->getData();

        $this->assertEquals(
            ['title' => 'My Title', 'description' => 'Some Description'],
            $data
        );
    }
}
