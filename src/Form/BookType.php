<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('type_document',ChoiceType::class, [
                'mapped'        => false,
                'required'      => false,
                'label'         => 'Media',
                'choices' => [
                    'Periodicals' => 'Periodicals',
                    'Print' => 'Print',
                    'Manuscript' => 'Manuscript',
                    'Other' => 'Other',
                ],
            ])
            ->add('publication_place')
            ->add('publication_date')
            ->add('publisher')
            ->add('publisher_stated')
            ->add('publication_place_stated')
            ->add('publication_date_stated')
            ->add('status',ChoiceType::class, [
                'mapped'        => false,
                'required'      => false,
                'label'         => 'Status',
                'choices' => [
                    'In VL' => 'In VL',
                    'Was in VL' => 'Was in VL',
                    'V involvement' => 'V involvement',
                    'Conjectural' => 'Conjectural',
                    'Never in VL' => 'Never in VL',
                ],
            ])
            ->add('multivolume')
            ->add('volume')
            ->add('vol_number')
            ->add('source')
            ->add('marginalia')
            ->add('library')
            ->add('cote')
            ->add('provenance')
            ->add('ferney')
            ->add('digital_voltaire')
            ->add('external_resource')
            ->add('notes')
            ->add('author')
            ->add('editor')
            ->add('copyst')
            ->add('translator')
            ->add('classification')
            ->add('pot_pourri')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
