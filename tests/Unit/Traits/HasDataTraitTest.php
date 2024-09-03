<?php

namespace AlibabaCloud\Client\Tests\Unit\Traits;

use PHPUnit\Framework\TestCase;

/**
 * Class HasDataTraitTest
 *
 * @package   AlibabaCloud\Client\Tests\Unit\Traits
 *
 * @coversDefaultClass \AlibabaCloud\Client\Traits\HasDataTrait
 */
class HasDataTraitTest extends TestCase
{
    /**
     * @dataProvider searchData
     *
     * @param array  $data
     * @param string $expression
     * @param mixed  $expected
     */
    public function testSearch(array $data, $expression, $expected)
    {
        // Setup
        $result = new HasDataTraitClass($data);

        // Assert
        self::assertEquals($expected, $result->search($expression));
    }

    /**
     * @return array
     */
    public function searchData()
    {
        return [
            [
                // Data
                [
                    'key' => [
                        'name' => 'value',
                    ],
                ],
                // Expression
                'key.name',
                // Expected
                'value',
            ],
            [
                // Data
                [
                    'key' => [
                        'name' => 'value',
                    ],
                ],
                // Expression
                'key',
                // Expected
                ['name' => 'value',],
            ],
            [
                // Data
                [
                    'key' => [
                        'name' => [
                            'value',
                        ],
                    ],
                ],
                // Expression
                'key.name',
                // Expected
                ['value'],
            ],
            [
                // Data
                [
                    'key' => [
                        'name' => [
                            'a',
                            'b',
                            'c',
                        ],
                    ],
                ],
                // Expression
                'key.name[2]',
                // Expected
                'c',
            ],
        ];
    }

    public function testAdd()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Assert
        self::assertEquals([], $result->all());

        // Test
        $result->add('a.b.c', 'value');

        // Assert
        self::assertEquals(
            [
                'a' => [
                    'b' => [
                        'c' => 'value',
                    ],
                ],
            ],
            $result->all()
        );

        // Test
        $result->add('b');

        // Assert
        self::assertEquals(
            [
                'a' => [
                    'b' => [
                        'c' => 'value',
                    ],
                ],
                'b' => null,
            ],
            $result->all()
        );
    }

    public function testClear()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->add('a.b.c', 'value');

        // Assert
        self::assertEquals(
            [
                'a' => [
                    'b' => [
                        'c' => 'value',
                    ],
                ],
            ],
            $result->all()
        );

        // Test
        $result->clear('a.b');

        // Assert
        self::assertEquals(
            [
                'a' => [
                    'b' => [],
                ],
            ],
            $result->all()
        );

        // Test
        $result->clear('a');

        // Assert
        self::assertEquals(['a' => [],], $result->all());

        // Test
        $result->clear();

        // Assert
        self::assertEquals([], $result->all());
    }

    public function testDelete()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->add('a.b.c', 'value');
        $result->delete('a.b.c');

        // Assert
        self::assertEquals(
            [
                'a' => [
                    'b' => [],
                ],
            ],
            $result->all()
        );
    }

    public function testFlatten()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->add('a.b.c', 'value');
        $result->add('b.c.d.e', 'value');

        // Assert
        self::assertEquals(
            [
                'a.b.c'   => 'value',
                'b.c.d.e' => 'value',
            ],
            $result->flatten()
        );
    }

    public function testGet()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->add('a.b.c', 'value');
        $result->add('b.c.d.e', 'value');

        // Assert
        self::assertEquals(null, $result->get('null'));

        // Assert
        self::assertEquals(
            [
                'b' => [
                    'c' => 'value',
                ],
            ],
            $result->get('a')
        );

        // Assert
        self::assertEquals(
            [
                'a' => [
                    'b' => [
                        'c' => 'value',
                    ],
                ],
                'b' => [
                    'c' => [
                        'd' => [
                            'e' => 'value',
                        ],
                    ],
                ],
            ],
            $result->get()
        );
    }

    public function testHas()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->add('a.b.c', 'value');
        $result->add('b.c.d.e', 'value');

        // Assert
        self::assertEquals(true, $result->has('a'));
        self::assertEquals(true, $result->has('a.b'));
        self::assertEquals(true, $result->has('a.b.c'));
        self::assertEquals(true, $result->has('b'));
        self::assertEquals(true, $result->has('b.c'));
        self::assertEquals(true, $result->has('b.c.d'));
        self::assertEquals(true, $result->has('b.c.d.e'));
        self::assertEquals(false, $result->has('e'));

        $result->clear();
        self::assertEquals(false, $result->has('a'));
    }

    public function testSetAndIsEmpty()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->set('a.b.c', 'value');

        // Assert
        self::assertEquals('value', $result->get('a.b.c'));
        self::assertEquals(false, $result->isEmpty('a.b.c'));
        self::assertEquals(true, $result->isEmpty('a.b.c.d'));

        // Test
        $result->set('b.c.d.e', 'value');

        // Assert
        self::assertEquals('value', $result->get('b.c.d.e'));
        self::assertEquals(false, $result->isEmpty('b.c.d.e'));
    }

    public function testSetReference()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->set('a.b.c', 'value');

        $array = [1, 2, 3];
        $result->setReference($array);

        // Assert
        self::assertEquals($array, $result->all());
    }

    public function testToJson()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->set('a.b.c', 'value');

        // Assert
        self::assertEquals('{"a":{"b":{"c":"value"}}}', $result->toJson());
    }

    public function testToArray()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->set('a.b.c', 'value');

        // Assert
        self::assertEquals($result->all(), $result->toArray());
    }

    public function testOffsetExists()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->set('a.b.c', 'value');

        // Assert
        self::assertEquals(true, isset($result['a']));
        self::assertEquals(true, isset($result['a.b.c']));
        self::assertEquals(false, isset($result['b']));
    }

    public function testOffsetGet()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->set('a.b.c', 'value');

        // Assert
        self::assertEquals('value', $result['a.b.c']);
        self::assertEquals(null, $result['b']);
    }

    public function testOffsetSet()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result->set('a.b.c', 'value');
        $result['d']     = 'd';
        $result['d.e.f'] = 'f';

        // Assert
        self::assertEquals('value', $result['a.b.c']);
        self::assertEquals(
            [
                'e' => [
                    'f' => 'f',
                ],
            ],
            $result['d']
        );
        self::assertEquals('f', $result['d.e.f']);
    }

    public function testOffsetUnSet()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Test
        $result['d.e.f'] = 'f';

        // Assert
        self::assertEquals(
            [
                'e' => [
                    'f' => 'f',
                ],
            ],
            $result['d']
        );

        // Test
        unset($result['d.e.f']);

        // Assert
        self::assertEquals(
            [
                'e' => [
                ],
            ],
            $result['d']
        );

        // Test
        unset($result['d.e']);

        // Assert
        self::assertEquals([], $result['d']);
    }

    public function testCount()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Assert
        self::assertEquals(0, $result->count());

        // Test
        $result['d.e.f'] = 'f';

        // Assert
        self::assertEquals(1, $result->count());

        // Test
        $result['e'] = 'e';

        // Assert
        self::assertEquals(2, $result->count());
    }

    public function testGetIterator()
    {
        // Setup
        $result = new HasDataTraitClass([]);

        // Assert
        self::assertInstanceOf(\ArrayIterator::class, $result->getIterator());
    }

    public function testJsonSerialize()
    {
        // Setup
        $result        = new HasDataTraitClass([]);
        $result['a.b'] = 'c';

        // Assert
        self::assertEquals(
            [
                'a' => [
                    'b' => 'c',
                ],
            ],
            $result->jsonSerialize()
        );
    }

    public function testObjectGet()
    {
        // Setup
        $result        = new HasDataTraitClass([]);
        $result['a.b'] = 'c';
        $result['d']   = 'e';

        // Assert
        self::assertEquals('c', $result->a->b);
        self::assertEquals('e', $result->d);
        self::assertEquals(null, $result->null);
    }

    public function testObjectSet()
    {
        // Setup
        $result    = new HasDataTraitClass([]);
        $result->a = 'a';
        $result->b = 'b';

        // Assert
        self::assertEquals('a', $result->a);
        self::assertEquals('b', $result->b);
    }

    public function testObjectIsSet()
    {
        // Setup
        $result    = new HasDataTraitClass([]);
        $result->a = 'a';

        // Assert
        self::assertEquals(true, isset($result->a));
        self::assertEquals(false, isset($result->b));
    }

    public function testObjectUnSet()
    {
        // Setup
        $result    = new HasDataTraitClass([]);
        $result->a = 'a';

        // Assert
        self::assertEquals(true, isset($result->a));

        // Test
        unset($result->a);

        // Assert
        self::assertEquals(false, isset($result->a));
    }
}
