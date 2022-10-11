<?php

namespace ProjectWithTests\SampleFile;

use ProjectWithTests\Parents\ParentClass;
use ProjectWithTests\Interfaces\ClassInterface;
use ProjectWithTests\TypeClasses\InjectedClassInConstructor;
use ProjectWithTests\TypeClasses\InjectedPublicClassInConstructor;
use Saeghe\SimplePackage\TypeClasses\InjectedClassFromPackageToConstructor;
use ProjectWithTests\TypeClasses\InjectedParameterClass;
use ProjectWithTests\TypeClasses\OtherInjectedParameterClass;
use ProjectWithTests\TypeClasses\ReturnTypeClassA;
use ProjectWithTests\TypeClasses\MultipleTypeA;
use ProjectWithTests\TypeClasses\MultipleTypeB;
use ProjectWithTests\TypeClasses\ReturnTypeClassB;
use ProjectWithTests\TypeClasses\ReturnTypeClassC;
use ProjectWithTests\ClassName\ClassA;
use ProjectWithTests\ClassName\ClassB;
use ProjectWithTests\Classes\NewInstanceClassA;
use Saeghe\SimplePackage\Classes\PackageClass;
use ProjectWithTests\Classes\NewInstanceClassB;
use ProjectWithTests\Classes\NewInstanceClassC;
use ProjectWithTests\Classes\StaticClassA;
use ProjectWithTests\Classes\StaticClassB;
use ProjectWithTests\Classes\StaticClassC;
use ProjectWithTests\Classes\ClassWithConstant;
use Saeghe\SimplePackage\Classes\PackageConst;
use ProjectWithTests\AnyNamespace as CompoundNamespace;
use ProjectWithTests\Attributes\SetUp;

class ImportableSampleClass extends ParentClass implements ClassInterface
{
    use TraitInSameNamespace;

    public function __construct(
        InjectedClassInConstructor $injectedClassInConstructor,
        public InjectedPublicClassInConstructor $injectedPublicClassInConstructor,
        public readonly InjectedClassFromPackageToConstructor $injectedClassA,
    ) {
    }

    protected function method_with_type_parameters(InjectedParameterClass $injectedParameterClass, OtherInjectedParameterClass $otherInjectedParameterClass)
    {
    }

    private function method_With_return_type(): ReturnTypeClassA
    {
    }

    public function method_with_multiple_type_parameter(MultipleTypeA|MultipleTypeB $parameter)
    {
    }

    public function method_with_multiple_return_types(): ReturnTypeClassB|ReturnTypeClassC
    {
    }

    public function get_class_name_examples()
    {
        $classNameA = ClassA::class;
        $classNameB = ClassInSameNamespace::class;
        if ($var instanceof CLassB::class) {

        }
        $classNameFromCompoundNamespace = CompoundNamespace\ClassName::class;
    }

    public function new_instance_examples()
    {
        new self();
        new parent();
        new static();
        $newInstance = new NewInstanceClassA();
        $newFromPackage = new PackageClass();
        $newInstanceWithParameter = new NewInstanceClassB(new NewInstanceClassC);
        $newInSameNamespace = new InstanceFromClassInSameNamespace();
        $newInstanceClassWithoutUse = new ProjectWithTests\SubDirectory\ClassUseAnotherClass();
        $phpClassInstance = new \ArrayObject();
        $newInstanceForClassInCompoundNamespace = new CompoundNamespace\ClassA();
    }

    public function static_call_examples()
    {
        $staticCall = StaticClassA::call();
        $callInInnerClass = StaticClassB::run(StaticClassC::output($staticCall));
        $staticCallToCompoundNamespaceClass = CompoundNamespace\StaticClass::handle();
        \Locale::setDefault('en');
    }

    public function call_functions()
    {
        str_replace('', '', '');
        \strlen($var);
    }

    public function constants_examples()
    {
        self::ConstA;
        static::ConstB;
        ClassInSameNamespace::ConstC;
        ClassWithConstant::ConstD;
        CompoundNamespace\ConstInCompoundNamespace::ConstE;
        PackageConst::ConstF;
        \ReflectionProperty\IS_PUBLIC;
    }

    #[SetUp]
    public function use_attributes_example()
    {

    }
}
