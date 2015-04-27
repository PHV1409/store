<?php
namespace Store\BackendBundle\Controller;

use Store\BackendBundle\Entity\Slider;
use Store\BackendBundle\Form\SliderType;
Use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SliderController extends Controller{

    public function listAction(){

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $sliders = $em->getRepository('StoreBackendBundle:Slider')->getSliderByUser($user);
        return $this->render('StoreBackendBundle:Slider:list.html.twig',array(
            'sliders' => $sliders
        ));
    }

    public function viewAction($id){

        $em = $this->getDoctrine()->getManager();

        $sliders = $em->getRepository('StoreBackendBundle:Slider')->find($id);

        return $this->render('StoreBackendBundle:Slider:view.html.twig',
            array(
                'sliders' => $sliders,
            )
        );
    }

    public function removeAction($id){

        $em = $this->getDoctrine()->getManager();

        $slider = $em->getRepository('StoreBackendBundle:Slider')->find($id);

        $em->remove($slider);
        $em->flush();

        return $this->redirectToRoute('store_backend_slider_list');
    }


    public function newAction(Request $request){
        $slider = new Slider();

        $user = $this->getUser();

        $form = $this->createForm(new SliderType($user), $slider, array(
            'validation_groups' => 'new',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate',
                'action' => $this->generateUrl('store_backend_slider_new')
            )
        ));
        $form->handleRequest($request);

        if($form->isValid()){
            $slider->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($slider);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Votre diaporama a bien été créé.'
            );

            return $this->redirectToRoute('store_backend_slider_list');
        }

        return $this->render('StoreBackendBundle:Slider:new.html.twig',
            array(
                'form' => $form->createView(),
                'slider' =>$slider,
            )
        );

    }

    public function editAction(Request $request,Slider $id){

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $slider = $em->getRepository('StoreBackendBundle:Slider')->find($id);

        $form = $this->createForm(new SliderType($user), $id, array(
            'validation_groups' => 'edit',
            'attr' => array(
                'method' => 'post',
                'novalidate' => 'novalidate', // pour virer la validation html5
                'action' => $this->generateUrl('store_backend_slider_edit',
                        array('id' => $id->getId()))
            )
        ));

        $form->handleRequest($request);

        if($form->isValid()){
            $slider->upload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($id);
            $em->flush();

            return $this->redirectToRoute('store_backend_slider_list');
        }

        return $this->render('StoreBackendBundle:Slider:edit.html.twig',
            array(
                'form' => $form->createView(),
                'slider' => $slider,
            )
        );


    }



} 