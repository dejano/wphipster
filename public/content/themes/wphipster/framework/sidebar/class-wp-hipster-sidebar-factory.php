<?php
namespace wp_hipster\sidebar;

class WP_Hipster_Sidebar_Factory
{
    /**
     * Registers sidebars
     * @param $sidebars array sidebars settings file content
     * @return array
     */
    public static function register($sidebars)
    {
        $options = get_option(WPHIPSTER_OPTIONS_NAME);
        if (empty($options)) {
            return null;
        }
        $ids = [];
        foreach ($sidebars as $sidebar) {
            if (isset($sidebar['associated'])) {
                $association = $sidebar['associated'];
                $value = $options[$association['id']];

                switch ($association['type']) {
                    case WP_Hipster_Association_Type::REPEATABLE:
                        for ($i = 1; $i <= $value; $i++) {
                            $data = [
                                'name' => sprintf(__('%s %s', 'whipster'), $sidebar['name'], $i),
                                'id' => $sidebar['id'] . '-' . $i,
                                'description' => __($sidebar['description'], 'whipster'),
                                'before_widget' => $sidebar['before_widget'],
                                'after_widget' => $sidebar['after_widget'],
                                'before_title' => $sidebar['before_title'],
                                'after_title' => $sidebar['after_title'],
                            ];
                            $ids[] = register_sidebar($data);
                        }
                        break;
                }
            } else {
                $ids[] = register_sidebar($sidebar);
            }
        }

        return $ids;
    }

}