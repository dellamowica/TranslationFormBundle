<?php

namespace A2lix\TranslationFormBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormView,
    Symfony\Component\Form\FormInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;
use A2lix\TranslationFormBundle\TranslationForm\TranslationForm;

/**
 * Regroup by locales, all translations fields
 *
 * @author David ALLIX
 */
class TranslationsType extends AbstractType
{
    private $translationForm;
    private $locales;
    private $required;

    public function __construct(TranslationForm $translationForm, $locales, $required)
    {
        $this->translationForm = $translationForm;
        $this->locales = $locales;
        $this->required = $required;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $translatableConfig = $this->translationForm->initTranslatableConfiguration($builder->getParent()->getDataClass());
        $locales = $this->translationForm->getDistinctLocales($options['locales']);
        $childrenOptions = $this->translationForm->getChildrenOptions($options);

        if (isset($locales['default'])) {
            $builder->add('default', 'a2lix_translationsLocales', array(
                'locales' => (array) $locales['default'],
                'fields_options' => $childrenOptions,
                'inherit_data' => true,
            ));
        }

        $builder->add('translations', 'a2lix_translationsLocales', array(
            'locales' => $locales['translations'],
            'fields_options' => $childrenOptions,
            'translation_class' => $translatableConfig['translationClass']
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['locales'] = $options['locales'];
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'locales' => $this->locales,
            'required' => $this->required,
            'fields' => array(),
            'inherit_data' => true,
        ));
    }

    public function getName()
    {
        return 'a2lix_translations';
    }
}