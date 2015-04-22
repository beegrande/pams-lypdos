<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_document',
		'title' => 'Document',
		'fields' => array (
			array (
				'key' => 'field_5354c5df3bfad',
				'label' => 'Document accountable',
				'name' => 'document_accountable',
				'type' => 'textarea',
				'instructions' => 'Document must have a document owner assigned',
				'required' => 1,
				'default_value' => 'not assigned',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => 1,
				'formatting' => 'none',
			),
			array (
				'key' => 'field_539cbd3051619',
				'label' => 'Document responsible',
				'name' => 'document_responsible',
				'type' => 'text',
				'default_value' => 'Not defined',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5358fe0324187',
				'label' => 'Document Objective',
				'name' => 'doc_objective',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_53ecb37868d79',
				'label' => 'Document Principle',
				'name' => 'doc_principle',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_539b4a3c494ee',
				'label' => 'Classification',
				'name' => 'classification',
				'type' => 'select',
				'instructions' => 'Select the confidentiality classification',
				'choices' => array (
					'Public information' => 'Public information',
					'Internal information' => 'Internal information',
					'Sensitive information' => 'Sensitive information',
					'Confidential information' => 'Confidential information',
				),
				'default_value' => 'Internal information',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_53c67cc63cbbd',
				'label' => 'Stakeholders',
				'name' => 'stakeholders',
				'type' => 'user',
				'role' => array (
					0 => 'all',
				),
				'field_type' => 'multi_select',
				'allow_null' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'ctrl_doc',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'definition',
					'order_no' => 0,
					'group_no' => 2,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_external-links',
		'title' => 'External links',
		'fields' => array (
			array (
				'key' => 'field_5369f8876a92c',
				'label' => 'External references',
				'name' => 'external_references',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'rows' => 3,
				'formatting' => 'br',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'definition',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'ctrl_doc',
					'order_no' => 0,
					'group_no' => 2,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_services',
		'title' => 'Services',
		'fields' => array (
			array (
				'key' => 'field_53660818ccd4b',
				'label' => 'Supporting services',
				'name' => 'supporting_services',
				'type' => 'relationship',
				'return_format' => 'object',
				'post_type' => array (
					0 => 'service',
				),
				'taxonomy' => array (
					0 => 'all',
				),
				'filters' => array (
					0 => 'search',
					1 => 'post_type',
				),
				'result_elements' => array (
					0 => 'post_type',
					1 => 'post_title',
				),
				'max' => '',
			),
			array (
				'key' => 'field_536610168f828',
				'label' => 'Service owner',
				'name' => 'service_owner',
				'type' => 'text',
				'required' => 1,
				'default_value' => 'NoName',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5366107f8f82a',
				'label' => 'Technical responsible',
				'name' => 'technical_responsible',
				'type' => 'text',
				'required' => 1,
				'default_value' => 'NoName',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5367969a749ae',
				'label' => 'Lifecycle stage',
				'name' => 'lifecycle_stage',
				'type' => 'select',
				'instructions' => 'Select lifecycle stage',
				'required' => 1,
				'choices' => array (
					'Defining requirements' => 'Defining requirements',
					'Requirements approved' => 'Requirements approved',
					'Chartered' => 'Chartered',
					'Designing' => 'Designing',
					'Developing' => 'Developing',
					'Testing' => 'Testing',
					'Operational' => 'Operational',
					'Retired' => 'Retired',
					'' => '',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_536638ad76975',
				'label' => 'Service hours',
				'name' => 'service_hours',
				'type' => 'select',
				'required' => 1,
				'choices' => array (
					'24/7' => '24/7',
					'07:00 - 17:00' => '07:00 - 17:00',
				),
				'default_value' => '07-17',
				'allow_null' => 0,
				'multiple' => 0,
			),
			array (
				'key' => 'field_54b9363cff211',
				'label' => 'Escalation contact',
				'name' => 'escalation_contact',
				'type' => 'text',
				'default_value' => '[Enter Name/Function]',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'service',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
	register_field_group(array (
		'id' => 'acf_review',
		'title' => 'Review',
		'fields' => array (
			array (
				'key' => 'field_5354cce8145d4',
				'label' => 'review interval',
				'name' => 'review_interval',
				'type' => 'text',
				'instructions' => 'Examples:
	1 year,
	6 months,
	365 days',
				'required' => 1,
				'default_value' => '1 year',
				'placeholder' => '',
				'prepend' => 'Revision interval:',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'service',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'definition',
					'order_no' => 0,
					'group_no' => 2,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'ctrl_doc',
					'order_no' => 0,
					'group_no' => 3,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 4,
	));
}
