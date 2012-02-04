<?php

class CreateObjectAccessRoles extends Ruckusing_BaseMigration {

	public function up() {
    $objectRoles = $this->create_table('objecttypes_roles');
    $objectRoles->column('object_id', 'integer');
    $objectRoles->column('role_id', 'integer');
    $objectRoles->finish();
	}//up()

	public function down() {
    $this->drop_table('objecttypes_roles');
	}//down()
}
?>
