<?php

use Symfony\Component\DomCrawler\Field\ChoiceFormField;
use Symfony\Component\DomCrawler\Form as CrawlerForm;
use Symfony\Component\DomCrawler\Crawler;

trait Form
{
    /**
     * Select a form by id, fill it with inputs param and return it.
     *
     * @param Crawler $crawler
     * @param string  $formId
     * @param array   $inputs
     *
     * @return CrawlerForm
     */
    protected static function getFilledForm(Crawler $crawler, string $formId, array $inputs = [])
    {
        return $crawler->filter('form')->form($inputs);
    }

    /**
     * Tick all given checkboxes.
     *
     * @param CrawlerForm $form
     * @param array       $checkboxes
     */
    protected static function tickCheckboxes(CrawlerForm $form, array $checkboxes = [])
    {
        foreach ($checkboxes as $checkboxName) {
            $checkbox = $form[$checkboxName];
            if ($checkbox instanceof ChoiceFormField) {
                $checkbox->tick();
            }
        }
    }

    /**
     * Un-tick all given checkboxes.
     *
     * @param CrawlerForm $form
     * @param array       $checkboxes
     */
    protected static function unTickCheckboxes(CrawlerForm $form, array $checkboxes = [])
    {
        foreach ($checkboxes as $checkboxName) {
            $checkbox = $form[$checkboxName];
            if ($checkbox instanceof ChoiceFormField) {
                $checkbox->untick();
            }
        }
    }
}
