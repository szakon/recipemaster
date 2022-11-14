<?php

namespace App\Controller;

use App\Entity\Member;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    /**
     * Controleur member
     * @Route("/member")
     */
    public function indexmember(): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Welcome!</title>
    </head>
    <body>
        <h1>Welcome</h1>
            
    <p>Welcome to </p>
    </body>
</html>';
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
    }

    /**
     * Lists of all bookshop entities
     *
     * @Route("/list", name = "member_list", methods = "GET")
     * @Route("/index", name = "member_index", methods = "GET")
     */

    public function listAction(ManagerRegistry $doctrine): Response
    {
        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Our members!</title>
    </head>
    <body>
        <h1>Our members</h1>
        <p>Here are all members:</p>
        <ul>';

        $entityManager= $doctrine->getManager();
        $members = $entityManager->getRepository(Member::class)->findAll();
        foreach($members as $member) {
            $htmlpage .= '<li>
            <a href="/bookshelf/'.$member->getid().'">'.$member->getName().' "('.$member->getid().')"</a></li>';
        }
        $htmlpage .= '</ul>';

        $htmlpage .= '</body></html>';

        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
        );
    }

    /**
     * Show a member (library)
     *
     * @Route("/member/{id}", name="member_show", requirements={"id"="\d+"})
     *    note that the id must be an integer, above
     *
     * @param Integer $id
     */
    public function show(ManagerRegistry $doctrine, $id)
    {
        $memberRepo = $doctrine->getRepository(Member::class);
        $member = $memberRepo->find($id);

        if (!$member) {
            throw $this->createNotFoundException('This member does not exist');
        }

        $res = '<!DOCTYPE html>
    <html>
    <head>
    <meta charset="UTF-8">
    <title>member '.$member->getName().' details</title>
 
</head>
<body>
<h2> '.$member->getName().' : </h2>
<ul><dl>';

        //Author, cuisine, year
        foreach($member->get() as $cookbook) {
            $res .= '<dt>COOKBOOK</dt><dd>' . $cookbook->__toString() . '</dd>';
        }
        $res .= '</dl>';
        $res .= '</ul></body></html>';


        $res .= '<p/><a href="' . $this->generateUrl('bookshelf_index') . '">Back</a>';

        return new Response('<html><body>'. $res . '</body></html>');
    }

}