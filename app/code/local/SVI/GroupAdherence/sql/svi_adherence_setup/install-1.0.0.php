<?php

/**
 * @author Ivan Semerenko <Semerenko888@yandex.ru>
 * @copyright Copyright (c) 2017, Ivan Semerenko
 */

/** @var Mage_Core_Model_Resource_Setup $this */
$installer = $this;

$installer->startSetup();

$table= $installer->getConnection()
                  ->newTable($installer->getTable('svi_groupAdherence/adherence'))
                  ->addColumn(
                      'rule_id',
                      Varien_Db_Ddl_Table::TYPE_INTEGER,
                      null,
                      [
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true,
                        'identity' => true,
                      ],
                      'Rule ID'
                  )
                  ->addColumn(
                      'rule_name',
                      Varien_Db_Ddl_Table::TYPE_VARCHAR,
                      128,
                      [
                          'nullable' => false,
                      ],
                      'Rule title'
                  )
                    ->addColumn(
                        'group_id',
                        Varien_Db_Ddl_Table::TYPE_INTEGER,
                        null,
                        [
                            'nullable' => false,
                        ]
                    )
                    ->addColumn(
                        'groups_serialized',
                        Varien_Db_Ddl_Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => true,
                        ]
                    )
                    ->addColumn(
                        'websites_serialized',
                        Varien_Db_Ddl_Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => true,
                        ]
                    )
                    ->addColumn(
                        'conditions_serialized',
                        Varien_Db_Ddl_Table::TYPE_TEXT,
                        null,
                        [
                            'nullable' => true,
                        ]
                    )
                  ->addColumn(
                      'hierarchy',
                      Varien_Db_Ddl_Table::TYPE_INTEGER,
                      null,
                      [
                          'nullable' => true,
                      ]
                  )
                  ->addColumn(
                      'rule_status',
                      Varien_Db_Ddl_Table::TYPE_SMALLINT,
                      2,
                      [
                          'nullable' => false,
                          'default'  => 1
                      ]
                  )
                  ->setComment('Manage Rules table');

$installer->getConnection()->createTable($table);

$installer->endSetup();
