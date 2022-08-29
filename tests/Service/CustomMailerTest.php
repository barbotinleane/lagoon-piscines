<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomMailerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = $this->createClient();

        $crawler = $client->request('GET', '/votre-projet');
        $this->assertResponseIsSuccessful();

        $button = $crawler->selectButton('Valider');
        $form = $button->form();

        $form['project_ask[firstName]']->setValue('John');
        $form['project_ask[lastName]']->setValue('Doe');
        $form['project_ask[email]']->setValue('john@doe.fr');
        $form['project_ask[phone]']->setValue('0601020304');
        $form['project_ask[address]']->setValue('1 rue de la paix');
        $form['project_ask[postalCode]']->setValue('01000');
        $form['project_ask[city]']->setValue('Paris');
        $form['project_ask[department]']->select(1);
        $form['project_ask[country]']->setValue('France');
        $form['project_ask[waterSurface]']->setValue('25 m²');
        $form['project_ask[shape]']->setValue('Modèle pré-dessiné');
        $form['project_ask[poolColor]']->setValue(1);
        $form['project_ask[beach]']->setValue('Oui');
        $form['project_ask[beachColor]']->setValue('1');
        $form['project_ask[filtrationType]']->setValue('UV');
        $form['project_ask[heatPump]']->setValue('Oui');
        $form['project_ask[buildingStarts]']->setValue('31/08/2022');
        $form['project_ask[budget]']->setValue('20 000 €');
        $form['project_ask[notes]']->setValue('Je veux construire un lagoon.');

        $client->submit($form);
        $client->followRedirects();

        /*print_r( $client->getResponse()->getContent());
        $this->assertSelectorTextContains(
            '.alert',
            'Votre demande de devis a bien été envoyée.',
            'No text in flash message in homepage'
        );
        /*
        $this->assertEmailCount(1);

        $email = $this->getMailerMessage();

        $this->assertEmailHtmlBodyContains($email, 'Welcome');
        $this->assertEmailTextBodyContains($email, 'Welcome');*/
    }
}
