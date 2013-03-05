<?php

/*
 * This file is part of the Ivory CKEditor package.
 *
 * (c) Eric GELOEN <geloen.eric@gmail.com>
 *
 * For the full copyright and license information, please read the LICENSE
 * file that was distributed with this source code.
 */

namespace Caravane\CKEditorBundle\Form\Type;

use Caravane\CKEditorBundle\Model\ConfigManagerInterface,
    Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormView,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * CKEditor type
 *
 * @author GeLo <geloen.eric@gmail.com>
 */
class CKEditorType extends AbstractType
{
    /** @var \Caravane\CKEditorBundle\Model\ConfigManager */
    protected $configManager;

    /**
     * Creates a CKEditor type.
     *
     * @param \Caravane\CKEditorBundle\Model\ConfigManagerInterface $configManager The CKEditor config manager.
     */
    public function __construct(ConfigManagerInterface $configManager)
    {
        $this->configManager = $configManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $config = $options['config'];

        if ($options['config_name'] !== null) {
            $config = array_merge($this->configManager->getConfig($options['config_name']), $config);
        }

        $builder->setAttribute('config', $config);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars = array_replace($view->vars, array(
            'config'  => $form->getAttribute('config'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'required'    => false,
            'config_name' => null,
            'config'      => array(),
        ));

        $resolver->addAllowedValues(array('required' => array(false)));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'textarea';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ckeditor';
    }
}
