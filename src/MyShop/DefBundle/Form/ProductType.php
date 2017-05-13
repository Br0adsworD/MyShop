<?php

namespace MyShop\DefBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;


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
            ->add('os',TextType::class,['label'=>'Операциона система','required'=>false])
            ->add('screen_size',TextType::class,['label'=>'Размер экрана','required'=>false])
            ->add('screen_resolution',TextType::class,['label'=>'Разрешение экрана','required'=>false])
            ->add('type_screen',TextType::class,['label'=>'Тип экрана','required'=>false])
            ->add('processor',TextType::class,['label'=>'Процессор','required'=>false])
            ->add('ram',TextType::class,['label'=>'RAM','required'=>false])
            ->add('quantity_sim',TextType::class,['label'=>'Кол-во SIM','required'=>false])
            ->add('camera',TextType::class,['label'=>'Камера','required'=>false])
            ->add('weight',TextType::class,['label'=>'Вес','required'=>false])
            ->add('availability_sim',TextType::class,['label'=>'Наличие SIM','required'=>false])
            ->add('type_ram',TextType::class,['label'=>'Тип RAM','required'=>false])
            ->add('quantity_socket_ram',TextType::class,['label'=>'Кол-во слотов RAM','required'=>false])
            ->add('video_card',TextType::class,['label'=>'Графический адаптер','required'=>false])
            ->add('network_adapter',TextType::class,['label'=>'Сетевой адаптер','required'=>false])
            ->add('battery',TextType::class,['label'=>'Батарея','required'=>false])
            ->add('description',CKEditorType::class,['label'=>' ','required'=>false])
            ->add('guarantee',TextType::class,['label'=>'Гарантия','required'=>false])
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
