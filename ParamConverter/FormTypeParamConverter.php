<?php

namespace Netshark\Bundle\FrameworkBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\Request;

final class FormTypeParamConverter implements ParamConverterInterface
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $form = $this->formFactory->create($configuration->getClass());
        
        if (!$form instanceof FormTypeInterface) {
            return false;
        }
        
        $request->attributes->set($configuration->getName(), $form);
        
        return true;
    }

    public function supports(ParamConverter $configuration)
    {
        return is_subclass_of($configuration->getClass(), FormTypeInterface::class);
    }
}
