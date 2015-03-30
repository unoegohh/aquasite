<?php
namespace Unoegohh\EntitiesBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Unoegohh\EntitiesBundle\Entity\BottomImage;
use Unoegohh\EntitiesBundle\Entity\SitePref;

class AddBottomImagesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('unoegohh:entity:addimages')
            ->setDescription('creates site prefs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->getContainer()->get('doctrine')->getManager();

        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:BottomImage');

        $pref = new BottomImage();
        $pref->setActive(true);
        $pref->setName("Portotecnica");
        $pref->setImage("/logos/Portotecnica.png");
        $pref->setItemOrder(1);
        $em->persist($pref);

        $pref1 = new BottomImage();
        $pref1->setActive(true);
        $pref1->setName("Soteco");
        $pref1->setImage("/logos/Soteco.png");
        $pref1->setItemOrder(2);
        $em->persist($pref1);

        $pref2 = new BottomImage();
        $pref2->setActive(false);
        $pref2->setName("RM");
        $pref2->setImage("/logos/RM.png");
        $pref2->setItemOrder(3);
        $em->persist($pref2);

        $pref3 = new BottomImage();
        $pref3->setActive(false);
        $pref3->setName("PA");
        $pref3->setImage("/logos/PA.png");
        $pref3->setItemOrder(4);
        $em->persist($pref3);

        $pref4 = new BottomImage();
        $pref4->setActive(true);
        $pref4->setName("Hawk");
        $pref4->setImage("/logos/Hawk.png");
        $pref4->setItemOrder(5);
        $em->persist($pref4);

        $pref5 = new BottomImage();
        $pref5->setActive(false);
        $pref5->setName("Procar");
        $pref5->setImage("/logos/Procar%20color-logo.png");
        $pref5->setItemOrder(6);
        $em->persist($pref5);

        $pref6 = new BottomImage();
        $pref6->setActive(false);
        $pref6->setName("VMD");
        $pref6->setImage("/logos/VMD.png");
        $pref6->setItemOrder(7);
        $em->persist($pref6);

        $pref7 = new BottomImage();
        $pref7->setActive(true);
        $pref7->setName("CID");
        $pref7->setImage("/logos/cid_lines.png");
        $pref7->setItemOrder(8);
        $em->persist($pref7);

        $pref8 = new BottomImage();
        $pref8->setActive(true);
        $pref8->setName("Kenotek");
        $pref8->setImage("/logos/Kenotek.png");
        $pref8->setItemOrder(9);
        $em->persist($pref8);

        $pref9 = new BottomImage();
        $pref9->setActive(false);
        $pref9->setName("EME");
        $pref9->setImage("/logos/EME.png");
        $pref9->setItemOrder(10);
        $em->persist($pref9);

        $pref10 = new BottomImage();
        $pref10->setActive(true);
        $pref10->setName("Tornado");
        $pref10->setImage("/logos/Tornado.png");
        $pref10->setItemOrder(11);
        $em->persist($pref10);

        $pref11 = new BottomImage();
        $pref11->setActive(true);
        $pref11->setName("interpump");
        $pref11->setImage("/logos/interpump.png");
        $pref11->setItemOrder(12);
        $em->persist($pref11);
        $em->flush();

        $output->writeln('DONE!');


    }
}