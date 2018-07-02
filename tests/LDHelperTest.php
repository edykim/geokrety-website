<?php

use PHPUnit\Framework\TestCase;

class LDHelperTest extends TestCase {
    const LD_JSON_SCRIPT_START = '<script type="application/ld+json">';
    const LD_JSON_SCRIPT_END = '</script>';
    const KEYWORDS_EXAMPLE = 'this,is,a,test';

    public function test_generate_ld_json_article() {
        // GIVEN
        $ldHelper = new LDHelper('geokrety.org', 'https://geokrety.org', 'https://cdn.geokrety.org/images/banners/geokrety.png');
        $testDate = date('c', 12345000);

        // WHEN
        $ldJSONArticle = $ldHelper->helpArticle(
            'this is a test',
            'UTest generation',
            'http://exemple.com/article.html',
            'http://exemple.com/image.jpg',
            self::KEYWORDS_EXAMPLE,
            'fr',
            $testDate,
            $testDate,
            'http://exemple.com/'
            );

        // THEN
        $expectedResult = self::LD_JSON_SCRIPT_START
        .'{'
        .'"@context":"http:\/\/schema.org",'
        .'"@type":"Article",'
        .'"url":"http:\/\/exemple.com\/article.html",'
        .'"description":"UTest generation",'
        .'"image":"http:\/\/exemple.com\/image.jpg",'
        .'"publisher":{"@type":"Organization","name":"geokrety.org","url":"https:\/\/geokrety.org",'
          .'"logo":{"@type":"ImageObject","url":"https:\/\/cdn.geokrety.org\/images\/banners\/geokrety.png"}},'
        .'"keywords":"'.self::KEYWORDS_EXAMPLE.'",'
        .'"inLanguage":"fr",'
        .'"dateModified":"1970-05-23T21:10:00+00:00",'
        .'"datePublished":"1970-05-23T21:10:00+00:00",'
        .'"author":{"@type":"Person","name":"geokrety.org"},'
        .'"mainEntityOfPage":"http:\/\/exemple.com\/",'
        .'"headline":"this is a test"'
        .'}'
        .self::LD_JSON_SCRIPT_END;

        $this->assertSame($expectedResult, $ldJSONArticle);
    }

    public function test_generate_ld_json_website() {
        // GIVEN
        $ldHelper = new LDHelper('geokrety.org', 'https://geokrety.org', 'https://cdn.geokrety.org/images/banners/geokrety.png');

        // WHEN
        // ($headline, $description, $imageUrl, $name, $siteUrl, $keywords)
        $ldJSONWebSite = $ldHelper->helpWebSite(
            'this is a test',
            'UTEST SITE Description',
            'https://exemple/images/logo.jpg',
            'My WebSite',
            'https://exemple.com',
            self::KEYWORDS_EXAMPLE
            );

        // THEN
        $expectedResult = self::LD_JSON_SCRIPT_START
        .'{'
        .'"@context":"http:\/\/schema.org",'
        .'"@type":"WebSite",'
        .'"about":"UTEST SITE Description",'
        .'"headline":"this is a test",'
        .'"image":"https:\/\/exemple\/images\/logo.jpg",'
        .'"name":"My WebSite",'
        .'"url":"https:\/\/exemple.com",'
        .'"keywords":"'.self::KEYWORDS_EXAMPLE.'"'
        .'}'
        .self::LD_JSON_SCRIPT_END;

        $this->assertSame($expectedResult, $ldJSONWebSite);
    }

    public function test_generate_ld_json_konkret() {
        // GIVEN
        $ldHelper = new LDHelper('geokrety.org', 'https://geokrety.org', 'https://cdn.geokrety.org/images/banners/geokrety.png');
        $konkret = new \Geokrety\Domain\Konkret();
        $konkret->name = 'konkret UT';
        $konkret->description = 'konkret unit test';
        $konkret->url = 'https://example.com/konkret.php';
        $konkret->author = 'Jojo';
        $konkret->authorUrl = 'https://example.com/author.php?name=Jojo';
        $konkret->datePublished = date('c', 12345000);
        $konkret->imageUrl = 'https://example.com/konkret.jpg';
        $konkret->keywords = self::KEYWORDS_EXAMPLE;
        $konkret->ratingCount = 10;
        $konkret->ratingAvg = 2.4;

        $log1 = new \Geokrety\Domain\KonkretLog('George', 'https://example.com/author.php?name=George', 'log1 content', date('c', 12345000));
        $log2 = new \Geokrety\Domain\KonkretLog('Robert', 'https://example.com/author.php?name=Robert', 'log2 content here', date('c', 12345000));

        $konkretLogs = array($log1, $log2);

        $konkret->commentCount = 2;
        $konkret->konkretLogs = $konkretLogs;

        // WHEN
        $ldJSONWebSite = $ldHelper->helpKonkret($konkret);

        // THEN
        $expectedResult = self::LD_JSON_SCRIPT_START
        .'{'
        .'"@context":"http:\/\/schema.org",'
        .'"@type":"Sculpture",'
        .'"about":"konkret unit test",'
        .'"image":"https:\/\/example.com\/konkret.jpg",'
        .'"name":"konkret UT",'
        .'"url":"https:\/\/example.com\/konkret.php",'
        .'"author":{"@type":"Person","name":"Jojo"},'
        .'"publisher":{"@type":"Organization","name":"geokrety.org","url":"https:\/\/geokrety.org","logo":{"@type":"ImageObject","url":"https:\/\/cdn.geokrety.org\/images\/banners\/geokrety.png"}},'
        .'"keywords":"'.self::KEYWORDS_EXAMPLE.'",'
        .'"datePublished":"1970-05-23T21:10:00+00:00",'
        .'"aggregateRating":{"@type":"AggregateRating","ratingValue":10,"bestRating":5,"worstRating":1,"ratingCount":2.4}'
        .'}'
        .self::LD_JSON_SCRIPT_END;

        // TODO: comments

        $this->assertSame($expectedResult, $ldJSONWebSite);
    }
}
