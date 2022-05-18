<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', TextareaType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir votre commentaire.'
                    ])
                ],
                'label' => false,
                'attr' => [
                    'placeholder' => 'Commenter l\'article',
                    'class' => 'form-control'
                ]
            ])
            ->add('article', HiddenType::class)
            ->add('user', HiddenType::class)
            ->add('publier', SubmitType::class, [
                'attr' => ['class' => 'btn_primary']
            ])
        ;

//        $builder->get('article')
//            ->addModelTransformer(new CallbackTransformer(
//                fn (Article $article) => $article->getId(),
//                fn (Article $article) => $article->getTitle()
//            ));
//        $builder->get('user')
//            ->addModelTransformer(new CallbackTransformer(
//                fn (User $user) => $user->getId(),
//                fn (User $user) => $user->getUsername()
//            ));
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
