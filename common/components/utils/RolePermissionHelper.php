<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\components\utils;

/**
 * Description of RolePermissionHelper
 *
 * @author nthanh
 */
class RolePermissionHelper
{
    /**
     * @check user in brand is admin
     * @param type $user_id
     * @param type $brand_id
     * @return boolean
     */
    public static function isAdmin($user_id, $brand_id)
    {
        return true;
    }
    
    public static function isMembershipAdmin($user_id, $brand_id){
        return true;
    }
    
    public static function isQuarkAdmin($user_id, $brand_id)
    {
        return true;
    }
    
    public static function isBrandAdmin($user_id, $brand_id){
        return true;
    }
    
    public static function isBrandMember($user_id, $brand_id){
        return true;
    }

    public static function isQuarkOwner($user_id, $quark_id)
    {
        return true;
    }

    // Pemission
    /**
     * 
     * @param type $user_id
     * @param type $brand_id
     */
    public static function canCreateQuark($user_id, $brand_id)
    {
        // check user has role admin
        // check user 
    }

    public static function canUpdateQuark($user_id, $brand_id)
    {
        /**
         * - Quark do la do user do tao ra
         * - User do co quyen admin
         * - User do co quyen quark admin
         */
    }

    public static function canDeleteQuark($user_id, $brand_id)
    {
        /**
         * - Quark do la do user do tao ra
         * - User do co quyen admin
         * - User do co quyen quark admin
         */
    }
    
    public static function canChangeBrandCover($user_id, $brand_id){
        /**
         * - User do co quyen admin
         * - User do co quyen brand admin
         */
    }
    
    public static function canResignUser($user_id, $brand_id){
        /**
         * - User do co quyen admin
         * - User do co quyen membership admin
         */
    }
    
    public static function canResignAdmin($user_id, $brand_id){
        /**
         * - User do co quyen admin
         * 
         */
    }

    // End permission
}
