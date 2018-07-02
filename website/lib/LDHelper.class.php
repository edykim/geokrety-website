<?php

/**
 * JSON-LD Helper, a way to generate JSON-LD ( W3C Recommendation as of 16 January 2014 : cf. https://json-ld.org/ )
 * This helps modern search engines to get website meta-information in a standardized way.
 **/
class LDHelper {
    public $geokretyName;
    public $geokretyUrl;
    public $geokretyLogoUrl;

    public $geokretyLogo;
    public $geokretyPerson;
    public $geokretyOrganization;

    public function __construct($geokretyName, $geokretyUrl, $geokretyLogoUrl) {
        $this->geokretyName = $geokretyName;
        $this->geokretyUrl = $geokretyUrl;
        $this->geokretyLogoUrl = $geokretyLogoUrl;

        $this->geokretyLogo = LDGeneratorFactory::createLdContext('ImageObject', [
            'url' => $geokretyLogoUrl,
        ]);
        /*
        $this->geokretyLogo = LDGeneratorFactory::createLdContext('ImageObject', [
            'url' => $geokretyLogoUrl,
        ]);
        */
        $this->geokretyPerson = $this->createAuthor($geokretyName, $geokretyUrl);
        $this->geokretyOrganization = $this->createOrganization($geokretyName, $geokretyUrl);
    }

    public function createOrganization($orgName, $orgUrl) {
        return LDGeneratorFactory::createLdContext('Organization', [
                'name' => $orgName,
                'url' => $orgUrl,
                'logo' => $this->geokretyLogo,
            ]);
    }

    public function createAuthor($authorName, $authorUrl) {
        return LDGeneratorFactory::createLdContext('Person', [
                'name' => $authorName,
            ]);
        // possible improvement: add 'sameAs' field in Torann Project
    }

    /**
     * schema used: http://schema.org/Article.
     *
     * help lang (inLanguage):
     * - https://tools.ietf.org/html/bcp47#section-2.1
     * - https://fr.wikipedia.org/wiki/Liste_des_codes_ISO_639-1
     */
    public function helpArticle($headline, $description, $articleUrl, $imageUrl, $keywords, $lang,
                                $dateModified, $datePublished, $mainEntityOfPage) {
        $context = LDGeneratorFactory::createLdContext('Article', [
            'headline' => $headline,
            'description' => $description,
            'url' => $articleUrl,
            'image' => $imageUrl,
            'author' => $this->geokretyPerson,
            'publisher' => $this->geokretyOrganization,
            'keywords' => $keywords,
            'inLanguage' => $lang,
            'dateModified' => $dateModified,
            'datePublished' => $datePublished,
            'mainEntityOfPage' => $mainEntityOfPage,
        ]);

        return $context->generate();
    }

    /**
     * schema used: http://schema.org/WebSite.
     *
     * Torann/json-ld PR 39 https://github.com/Torann/json-ld/pull/39
     */
    public function helpWebSite($headline, $description, $imageUrl, $name, $siteUrl, $keywords) {
        $context = LDGeneratorFactory::createLdContext('WebSite', [
            'about' => $description,
            'headline' => $headline,
            'url' => $siteUrl,
            'image' => $imageUrl,
            'name' => $name,
            'keywords' => $keywords,
            // Wait PR 39 // 'publisher' => $this->geokretyOrganization,
            // Wait PR 39 // 'inLanguage' => $lang,
            // Wait PR 39 // 'datePublished' => $datePublished,
        ]);

        return $context->generate();
    }

    public function createAggregateRating($ratingValue, $ratingCount) {
        return LDGeneratorFactory::createLdContext('AggregateRating', [
            'reviewCount' => null,
            'ratingValue' => $ratingValue,
            'bestRating' => 5,
            'worstRating' => 1,
            'ratingCount' => $ratingCount,
            ]);
    }

    /**
     * schema used: http://schema.org/Sculpture.
     */
    public function helpKonkret($konkret) {
        $context = LDGeneratorFactory::createLdContext('Sculpture', [
            'name' => $konkret->name,
            'url' => $konkret->url,
            'author' => $this->createAuthor($konkret->author, $konkret->authorUrl),
            'datePublished' => $konkret->datePublished,
            'image' => $konkret->imageUrl,
            'keywords' => $konkret->keywords,
            'about' => $konkret->description,
            'publisher' => $this->geokretyOrganization,
            'aggregateRating' => $this->createAggregateRating($konkret->ratingCount, $konkret->ratingAvg),
        ]);

        return $context->generate();
    }
}
