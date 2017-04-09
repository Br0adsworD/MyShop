<?php

namespace MyShop\DefBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('manufacturer',TextType::class,['label'=>"Производитель"])
        ->add('Model',TextType::class,['label'=>"Модель"])
        ->add('color',TextType::class,['label'=>"Цвет",'label_attr'=>array('color'=>'color')])
        ->add('price',TextType::class,['label'=>"Цена",'attr' => array('class' => 'price')])
        ->add('category',EntityType::class,['class'=>"MyShopDefBundle:Category",
                                            "choice_label"=>"name",
                                            'block_name'=>'asd',
                                            "label"=>"Категория",
                                            'attr'=>array('id'=>'get_action',
                                                          "class"=>"category",
                                                          'onchange'=>"set_action()",)])
        ->add('iconPhoto', FileType::class,['label'=>'Иконка товара','mapped'=>false])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MyShop\DefBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'myshop_defbundle_product';
    }


}
