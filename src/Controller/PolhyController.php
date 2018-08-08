<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;

class PolhyController extends Controller
{
    /**
     * @Route("/", name="polhy")
     */
    public function index(KernelInterface $kernel)
    {
        $values = Yaml::parseFile($kernel->getProjectDir().'/public/polhy.yml');

        return $this->render('polhy/index.html.twig', $values);
    }
}
