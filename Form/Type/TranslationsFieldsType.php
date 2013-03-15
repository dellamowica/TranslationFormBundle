<?php

namespace A2lix\TranslationFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Translations fields
 *
 * @author David ALLIX
 */
class TranslationsFieldsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        foreach ($options['fields'] as $fieldName => $fieldConfig) {
            $fieldType = $fieldConfig['type'];
            unset($fieldConfig['type']);

            $builder->add($fieldName, $fieldType, $fieldConfig);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'fields' => array(),
        ));
    }

    public function getName()
    {
        return 'a2lix_translationsFields';
    }
}
