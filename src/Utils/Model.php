<?php

namespace LasseRafn\DKS\Utils;

class Model
{
	public function __construct( $data = [] ) {
		$data = (array) $data;

		foreach ( $data as $attribute => $value ) {
			$attribute = is_string( $attribute ) ? trim( $attribute ) : $attribute;

			if ( ! method_exists( $this, 'set' . ucfirst( $this->camelCase( $attribute ) ) . 'Attribute' ) ) {
				$this->setAttribute( $attribute, $value );
			} else {
				$this->setAttribute( $attribute, $this->{'set' . ucfirst( $this->camelCase( $attribute ) ) . 'Attribute'}( $value ) );
			}
		}
	}

	public function __toString() {
		return json_encode( $this->toArray() );
	}

	/**
	 * Returns an array of the models public attributes.
	 *
	 * @return array
	 */
	public function toArray() {
		$data       = [];
		$class      = new \ReflectionObject( $this );
		$properties = $class->getProperties( \ReflectionProperty::IS_PUBLIC );

		/** @var \ReflectionProperty $property */
		foreach ( $properties as $property ) {
			if ( $this->{$property->getName()} === null ) {
				continue;
			}

			if ( $this->{$property->getName()} instanceof Model ) {
				$data[ $property->getName() ] = $this->{$property->getName()}->toArray();
			} elseif ( is_array( $this->{$property->getName()} ) ) {
				foreach ( $this->{$property->getName()} as $item => $value ) {
					if ( $value instanceof Model ) {
						$data[ $property->getName() ][ $item ] = $value->toArray();
					} else {
						$data[ $property->getName() ][ $item ] = $value;
					}
				}
			} else {
				$data[ $property->getName() ] = $this->{$property->getName()};
			}
		}

		return $data;
	}

	/**
	 * Set attribute of model.
	 *
	 * @param $attribute
	 * @param $value
	 */
	protected function setAttribute( $attribute, $value ) {
		$this->{$attribute} = $value;
	}

	/**
	 * Convert a string to camelCase.
	 *
	 * @param $string
	 *
	 * @return mixed
	 */
	private function camelCase( $string ) {
		$value = ucwords( str_replace( [ '-', '_' ], ' ', $string ) );
		$value = str_replace( ' ', '', $value );

		return lcfirst( $value );
	}

	/**
	 * Get PrimaryKey attribute.
	 *
	 * @return string
	 */
	public function getPrimaryKey() {
		return $this->primaryKey;
	}
}
