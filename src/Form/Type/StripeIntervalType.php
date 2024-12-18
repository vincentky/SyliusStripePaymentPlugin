<?php

declare(strict_types=1);

namespace VK\SyliusStripePaymentPlugin\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use VK\SyliusStripePaymentPlugin\Service\StripeServiceInterface;

final class StripeIntervalType extends AbstractType
{
    private DataTransformerInterface $transformer;

    public function __construct(DataTransformerInterface $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('amount', NumberType::class, [
            'error_bubbling' => false,
            'constraints' => [
                new NotBlank([
                    'groups' => ['recurring_product_variant'],
                ]),
                new GreaterThan([
                    'value' => 0,
                    'groups' => ['recurring_product_variant'],
                ]),
            ],
        ]);
        $builder->add('step', ChoiceType::class, [
            'choices' => array_combine(
                StripeServiceInterface::SUPPORTED_INTERVAL_STEPS,
                StripeServiceInterface::SUPPORTED_INTERVAL_STEPS
            ),
            'label' => false,
            'error_bubbling' => false,
            'choice_label' => function (string $value): string {
                return sprintf(
                    'sylius_stripe_payment_plugin.form.product_variant.interval_configuration.steps.%s',
                    $value
                );
            },
        ]);
        $builder->addViewTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'compound' => true,
            'label_format' => 'sylius_stripe_payment_plugin.form.product_variant.interval_configuration.%name%',
            'error_bubbling' => true,
        ]);
    }
}
