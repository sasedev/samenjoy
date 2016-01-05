<?php

namespace Samenjoy\FrontBundle\Controller;

use SASEdev\Commons\SharedBundle\Controller\BaseController;
use Samenjoy\DataBundle\Entity\ColWeekly;
use Samenjoy\DataBundle\Entity\Brand;
use Samenjoy\DataBundle\Entity\ColType;
use Samenjoy\DataBundle\Entity\ColGroup;
use Samenjoy\DataBundle\Entity\ProdGroup;
use Samenjoy\DataBundle\Entity\Product;
use Samenjoy\DataBundle\Entity\Role;
use Samenjoy\DataBundle\Entity\User;
use Samenjoy\DataBundle\Entity\Discount;
use Samenjoy\DataBundle\Entity\ProdGroupImage;
use Samenjoy\DataBundle\Entity\Staticpage;

/**
 *
 * @author sasedev <seif.salah@gmail.com>
 */
class SetupController extends BaseController
{
    public function setupAction()
    {
        $em = $this->getEntityManager();

        $lngFR = 'fr';

        $lngEN = 'en';

        $lngNL = 'nl';

        $RoleUser = $em->getRepository('SamenjoyDataBundle:Role')
        ->findOneBy(array('name' => 'ROLE_USER'));

        if (null == $RoleUser) {
            $RoleUser = new Role();
            $RoleUser->setName('ROLE_USER');
            $RoleUser->setDescription('Simple User');
        }

        $em->persist($RoleUser);
        $em->flush();

        $RoleAdmin = $em->getRepository('SamenjoyDataBundle:Role')
        ->findOneBy(array('name' => 'ROLE_ADMIN'));

        if (null == $RoleAdmin) {
            $RoleAdmin = new Role();
            $RoleAdmin->setName('ROLE_ADMIN');
            $RoleAdmin->setDescription('Simple Admin');

            $RoleAdmin->addParent($RoleUser);
            $RoleUser->addChild($RoleAdmin);
        }

        $em->persist($RoleAdmin);
        $em->persist($RoleUser);
        $em->flush();

        $RoleSAdmin = $em->getRepository('SamenjoyDataBundle:Role')
        ->findOneBy(array('name' => 'ROLE_SUPERADMIN'));

        if (null == $RoleSAdmin) {
            $RoleSAdmin = new Role();
            $RoleSAdmin->setName('ROLE_SUPERADMIN');
            $RoleSAdmin->setDescription('Super Admin');

            $RoleSAdmin->addParent($RoleAdmin);
            $RoleAdmin->addChild($RoleSAdmin);
        }

        $em->persist($RoleSAdmin);
        $em->persist($RoleAdmin);
        $em->flush();

        $SUser = $em->getRepository('SamenjoyDataBundle:User')
        ->findOneBy(array('username' => 'admin'));

        if (null == $SUser) {
            $SUser = new User();
            $SUser->setUsername('admin');
            $SUser->setEmail('seifeddine.salah@gmail.com');
            $SUser->setClearPassword('alphatester');
            $SUser->setFirstName('Abdelkader Seif Eddine');
            $SUser->setLastName('Salah');
            $SUser->setSexe(User::SEXE_MR);
            $SUser->setPhone('+216.73465724');
            $SUser->setMobile('+216.99455153');
            $SUser->setLang($lngFR);

            $SUser->addUserRole($RoleSAdmin);
            $RoleSAdmin->addUser($SUser);

            $em->persist($SUser);
            $em->persist($RoleSAdmin);
            $em->flush();
        }

        $contactFR = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/contact', 'lang' => $lngFR));
        if (null == $contactFR) {
            $contactFR = new Staticpage();
            $contactFR->setUrl('/contact');
            $contactFR->setLang($lngFR);
            $contactFR->setTitle('Contactez-nous');
            $contactFR->setHtmlTitle('Contactez-nous');
            $contactFR->setMetaKeywords('Samenjoy Page Contact');
            $contactFR->setMetaDescription('Samenjoy Page Contact');

            $em->persist($contactFR);
            $em->flush();
        }

        $contactEN = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/contact', 'lang' => $lngEN));
        if (null == $contactEN) {
            $contactEN = new Staticpage();
            $contactEN->setUrl('/contact');
            $contactEN->setLang($lngEN);
            $contactEN->setTitle('Contact-us');
            $contactEN->setHtmlTitle('Contact-us');
            $contactEN->setMetaKeywords('Samenjoy Contact Page');
            $contactEN->setMetaDescription('Samenjoy Contact Page');

            $em->persist($contactEN);
            $em->flush();
        }

        $contactNL = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/contact', 'lang' => $lngNL));
        if (null == $contactNL) {
            $contactNL = new Staticpage();
            $contactNL->setUrl('/contact');
            $contactNL->setLang($lngNL);
            $contactNL->setTitle('Contacteer ons');
            $contactNL->setHtmlTitle('Contacteer ons');
            $contactNL->setMetaKeywords('Samenjoy Contactpagina');
            $contactNL->setMetaDescription('Samenjoy Contactpagina');

            $em->persist($contactNL);
            $em->flush();
        }

        $aboutFR = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/about', 'lang' => $lngFR));
        if (null == $aboutFR) {
            $aboutFR = new Staticpage();
            $aboutFR->setUrl('/about');
            $aboutFR->setLang($lngFR);
            $aboutFR->setTitle('Qui sommes nous');
            $aboutFR->setHtmlTitle('A propos de nous');
            $aboutFR->setMetaKeywords('A propos de nous');
            $aboutFR->setMetaDescription('A propos de nous');

            $em->persist($aboutFR);
            $em->flush();
        }

        $aboutEN = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/about', 'lang' => $lngEN));
        if (null == $aboutEN) {
            $aboutEN = new Staticpage();
            $aboutEN->setUrl('/about');
            $aboutEN->setLang($lngEN);
            $aboutEN->setTitle('About-us');
            $aboutEN->setHtmlTitle('About-us');
            $aboutEN->setMetaKeywords('About-us');
            $aboutEN->setMetaDescription('About-us');

            $em->persist($aboutEN);
            $em->flush();
        }

        $aboutNL = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/about', 'lang' => $lngNL));
        if (null == $aboutNL) {
            $aboutNL = new Staticpage();
            $aboutNL->setUrl('/about');
            $aboutNL->setLang($lngNL);
            $aboutNL->setTitle('Wie zijn wij?');
            $aboutNL->setHtmlTitle('Over ons');
            $aboutNL->setMetaKeywords('Over ons');
            $aboutNL->setMetaDescription('Over ons');

            $em->persist($aboutNL);
            $em->flush();
        }

        $cguFR = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/cgu', 'lang' => $lngFR));
        if (null == $cguFR) {
            $cguFR = new Staticpage();
            $cguFR->setUrl('/cgu');
            $cguFR->setLang($lngFR);
            $cguFR->setTitle('Conditions Générales d\'Utilisation');
            $cguFR->setHtmlTitle('Conditions Générales d\'Utilisation');
            $cguFR->setMetaKeywords('Conditions Générales d\'Utilisation');
            $cguFR->setMetaDescription('Conditions Générales d\'Utilisation');

            $em->persist($cguFR);
            $em->flush();
        }

        $cguEN = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/cgu', 'lang' => $lngEN));
        if (null == $cguEN) {
            $cguEN = new Staticpage();
            $cguEN->setUrl('/cgu');
            $cguEN->setLang($lngEN);
            $cguEN->setTitle('Terms of use');
            $cguEN->setHtmlTitle('Terms of use');
            $cguEN->setMetaKeywords('Terms of use');
            $cguEN->setMetaDescription('Terms of use');

            $em->persist($cguEN);
            $em->flush();
        }

        $cguNL = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/cgu', 'lang' => $lngNL));
        if (null == $cguNL) {
            $cguNL = new Staticpage();
            $cguNL->setUrl('/cgu');
            $cguNL->setLang($lngNL);
            $cguNL->setTitle('Gebruiksvoorwaarden');
            $cguNL->setHtmlTitle('Algemene voorwaarden');
            $cguNL->setMetaKeywords('Algemene voorwaarden');
            $cguNL->setMetaDescription('Algemene voorwaarden');

            $em->persist($cguNL);
            $em->flush();
        }

        $cgvFR = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/cgv', 'lang' => $lngFR));
        if (null == $cgvFR) {
            $cgvFR = new Staticpage();
            $cgvFR->setUrl('/cgv');
            $cgvFR->setLang($lngFR);
            $cgvFR->setTitle('Conditions Générales de Vente');
            $cgvFR->setHtmlTitle('Conditions Générales de Vente');
            $cgvFR->setMetaKeywords('Conditions Générales de Vente');
            $cgvFR->setMetaDescription('Conditions Générales de Vente');

            $em->persist($cgvFR);
            $em->flush();
        }

        $cgvEN = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/cgv', 'lang' => $lngEN));
        if (null == $cgvEN) {
            $cgvEN = new Staticpage();
            $cgvEN->setUrl('/cgv');
            $cgvEN->setLang($lngEN);
            $cgvEN->setTitle('Terms of sales');
            $cgvEN->setHtmlTitle('Terms of sales');
            $cgvEN->setMetaKeywords('Terms of sales');
            $cgvEN->setMetaDescription('Terms of sales');

            $em->persist($cgvEN);
            $em->flush();
        }

        $cgvNL = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/cgv', 'lang' => $lngNL));
        if (null == $cgvNL) {
            $cgvNL = new Staticpage();
            $cgvNL->setUrl('/cgv');
            $cgvNL->setLang($lngNL);
            $cgvNL->setTitle('Algemene voorwaarden verkoop');
            $cgvNL->setHtmlTitle('Algemene verkoopvoorwaarden');
            $cgvNL->setMetaKeywords('Algemene verkoopvoorwaarden');
            $cgvNL->setMetaDescription('Algemene verkoopvoorwaarden');

            $em->persist($cgvNL);
            $em->flush();
        }

        $faqFR = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/faq', 'lang' => $lngFR));
        if (null == $faqFR) {
            $faqFR = new Staticpage();
            $faqFR->setUrl('/faq');
            $faqFR->setLang($lngFR);
            $faqFR->setTitle('Foire Aux Question');
            $faqFR->setHtmlTitle('F.A.Q');
            $faqFR->setMetaKeywords('F.A.Q');
            $faqFR->setMetaDescription('F.A.Q');

            $em->persist($faqFR);
            $em->flush();
        }

        $faqEN = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/faq', 'lang' => $lngEN));
        if (null == $faqEN) {
            $faqEN = new Staticpage();
            $faqEN->setUrl('/faq');
            $faqEN->setLang($lngEN);
            $faqEN->setTitle('Frequently Asked Question');
            $faqEN->setHtmlTitle('F.A.Q');
            $faqEN->setMetaKeywords('F.A.Q');
            $faqEN->setMetaDescription('F.A.Q');

            $em->persist($faqEN);
            $em->flush();
        }

        $faqNL = $em->getRepository('SamenjoyDataBundle:Staticpage')
        ->findOneBy(array('url' => '/faq', 'lang' => $lngNL));
        if (null == $faqNL) {
            $faqNL = new Staticpage();
            $faqNL->setUrl('/faq');
            $faqNL->setLang($lngNL);
            $faqNL->setTitle('Veelgestelde vragen');
            $faqNL->setHtmlTitle('Veelgestelde vragen');
            $faqNL->setMetaKeywords('Veelgestelde vragen');
            $faqNL->setMetaDescription('Veelgestelde vragen');

            $em->persist($faqNL);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('_front_homepage'));
    }
}