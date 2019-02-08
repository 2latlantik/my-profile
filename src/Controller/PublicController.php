<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PublicController
 * @package App\Controller
 */
class PublicController extends AbstractController
{
    /**
     * @Route(
     *     "/",
     *     name="homepage"
     * )
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->render('public/index.html.twig');
    }
}
