<?php

/**
 * oss逻辑类
 * 
 */
class OssServer extends BaseServer {

    //实例化一个oss
    public static function OssClient() {
        $oss = new Oss;
        return $oss->ossClient();
    }

    /**
     * 创建bucket，默认创建的bucket的ACL是OssClient::OSS_ACL_TYPE_PRIVATE
     *
     * @param string $bucket   名称
     * @param string $acl  读写权限，可选值 ['private', 'public-read', 'public-read-write']
     * @param array $options
     * @return null
     */
    public static function createBucket($bucket, $acl = 'public-read') {
        $OSS = self::OssClient();
        try {
            $OSS->createBucket($bucket, $acl);
        } catch (OssException $e) {
            return false;
        }
        return true;
    }

    /**
     * 删除bucket
     * 如果Bucket不为空（Bucket中有Object，或者有分块上传的碎片），则Bucket无法删除，
     * 必须删除Bucket中的所有Object以及碎片后，Bucket才能成功删除。
     *
     * @param string $bucket  名称
     * @param array $options
     * @return null
     */
    public static function deleteBucket($bucket) {
        $OSS = self::OssClient();
        try {
            $OSS->deleteBucket($bucket);
        } catch (OssException $e) {
            return false;
        }
        return true;
    }

    /**
     * 判断bucket是否存在
     *
     * @param string $bucket  名称
     * @return bool
     * @throws OssException
     */
    public static function doesBucketExist($bucket) {
        $OSS = self::OssClient();
        try {
            $OSS->doesBucketExist($bucket);
        } catch (OssException $e) {
            return false;
        }
        return true;
    }

    /**
     * 上传本地文件
     *
     * @param string $bucket bucket名称
     * @param string $object object名称
     * @param string $file 本地文件路径
     * @param array $options
     * @return null
     * @throws OssException
     */
    public static function uploadFile($bucket, $object, $file) {
        $OSS = self::OssClient();
        try {
            $OSS->uploadFile($bucket, $object, $file);
        } catch (OssException $e) {
            return false;
        }
        return true;
    }

    /**
     * 拷贝一个在OSS上已经存在的object成另外一个object
     *
     * @param string $fromBucket 源bucket名称
     * @param string $fromObject 源object名称
     * @param string $toBucket 目标bucket名称
     * @param string $toObject 目标object名称
     * @param array $options
     * @return null
     * @throws OssException
     */
    public static function copyObject($fromBucket, $fromObject, $toBucket, $toObject) {
        $OSS = self::OssClient();
        try {
            $OSS->copyObject($fromBucket, $fromObject, $toBucket, $toObject);
        } catch (OssException $e) {
            return false;
        }
        return true;
    }

    /**
     * 删除某个Object
     *
     * @param string $bucket bucket名称
     * @param string $object object名称
     * @param array $options
     * @return null
     */
    public static function deleteObject($bucket, $object) {
        $OSS = self::OssClient();
        try {
            $OSS->deleteObject($bucket, $object);
        } catch (OssException $e) {
            return false;
        }
        return true;
    }

    /**
     * 删除同一个Bucket中的多个Object
     *
     * @param string $bucket bucket名称
     * @param array $objects object列表
     * @param array $options
     * @return ResponseCore
     * @throws null
     */
    public static function deleteObjects($bucket, $objects) {
        $OSS = self::OssClient();
        try {
            $OSS->deleteObjects($bucket, $objects);
        } catch (OssException $e) {
            return false;
        }
        return true;
    }

    /**
     * 检测Object是否存在
     * 通过获取Object的Meta信息来判断Object是否存在， 用户需要自行解析ResponseCore判断object是否存在
     *
     * @param string $bucket bucket名称
     * @param string $object object名称
     * @param array $options
     * @return bool
     */
    public static function doesObjectExist($bucket, $object) {
        $OSS = self::OssClient();
        try {
            $OSS->doesObjectExist($bucket, $object);
        } catch (OssException $e) {
            return false;
        }
        return true;
    }

}
