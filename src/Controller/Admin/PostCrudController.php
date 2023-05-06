<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setSearchFields(['id', 'title', 'slug', 'category'])
            ->setDefaultSort(['id' => 'DESC'])
            ->setEntityLabelInPlural('Publicaciones')
            ->setEntityLabelInSingular('Publicación');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('user', 'Usuario'),
            AssociationField::new('category', 'Categoría'),
            TextField::new('title', 'Título'),
            SlugField::new('slug', 'Slug')->setTargetFieldName('title'),
            TextEditorField::new('content', 'Contenido'),
        ];
    }
}
