<?php
class GetCompositeMutator extends DtoTest\TestCase
{
    public function testDefaultValueReturned()
    {
        $dto = new \Dto\Dto();
        $value = $this->callProtectedMethod($dto, 'getCompositeMutator', ['']);
        $this->assertEquals('mutateTypeHash', $value);
    }
    
    /**
     * @expectedException \Dto\Exceptions\InvalidMutatorException
     */
    public function testExceptionThrownForUndefinedTypeMutator()
    {
        $meta = [
            '.x' => [
                'type' => 'does_not_exist'
            ]
        ];
        $dto = new \Dto\Dto([],[],$meta);
        $reflection = new ReflectionClass(get_class($dto));
        $method = $reflection->getMethod('getCompositeMutator');
        $method->setAccessible(true);
        
        $method->invokeArgs($dto, ['x']);
    }
    
    public function testFieldLevelMutatorReturnedWhenMethodExists()
    {
        $meta = [
            '.x' => [
                'type' => 'scalar'
            ]
        ];
        $dto = new TestGetCompositeMutatorDto([],[],$meta);
        $reflection = new ReflectionClass(get_class($dto));
        $method = $reflection->getMethod('getCompositeMutator');
        $method->setAccessible(true);
        
        $value = $method->invokeArgs($dto, ['x']);
        $this->assertEquals('mutateX', $value);
    }
    
    public function testTypeLevelMutatorReturned()
    {
        $meta = [
            '.x' => [
                'type' => 'boolean'
            ]
        ];
        $dto = new \Dto\Dto([],[],$meta);
        $reflection = new ReflectionClass(get_class($dto));
        $method = $reflection->getMethod('getCompositeMutator');
        $method->setAccessible(true);
    
        $value = $method->invokeArgs($dto, ['x']);
        $this->assertEquals('mutateTypeBoolean', $value);
    }
}

class TestGetCompositeMutatorDto extends \Dto\Dto {
    
    function mutateX($value) {
        return $value;
    }
}