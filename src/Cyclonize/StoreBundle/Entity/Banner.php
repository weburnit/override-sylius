<?php

namespace Cyclonize\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Banner
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Banner
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint")
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="clicks", type="bigint")
     */
    private $clicks;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="indexLayout", type="smallint")
     */
    private $indexLayout;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $photo;
    /**
     * used to identify the entity over URL paths
     * @ORM\Column(name="hash", type="string", length=255)
     */
    protected $hash;

    /**
     * @Assert\File(maxSize="4096k", mimeTypes={"image/jpeg", "image/png", "image/bmp", "image/gif", "video/mp4", "video/webm"}, mimeTypesMessage = "Only approve image or video less than 4mb")
     */
    private $file;

    const BANNER_TYPE_IMAGE = 1;
    const BANNER_TYPE_VIDEO = 2;

    public function __construct()
    {
        $this->clicks = 0;
        $this->hash = $this->generateReadableRandomString();
        $this->indexLayout = 1;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Set hash
     *
     * @param string $hash
     * @return BaseEntity
     */
    public function setHash($hash)
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Banner
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Banner
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return Banner
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set clicks
     *
     * @param integer $clicks
     * @return Banner
     */
    public function setClicks($clicks)
    {
        $this->clicks = $clicks;

        return $this;
    }

    /**
     * Get clicks
     *
     * @return integer
     */
    public function getClicks()
    {
        return $this->clicks;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Banner
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set indexLayout
     *
     * @param integer $indexLayout
     * @return Banner
     */
    public function setIndexLayout($indexLayout)
    {
        $this->indexLayout = $indexLayout;

        return $this;
    }

    /**
     * Get indexLayout
     *
     * @return integer
     */
    public function getIndexLayout()
    {
        return $this->indexLayout;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    public static function getTypeOptions()
    {
        return array(self::BANNER_TYPE_IMAGE => 'Image', self::BANNER_TYPE_VIDEO => 'Video');
    }


    public function getAbsolutePath($file = null)
    {
        return null === $file ? null : $this->getUploadRootDir() . '/' . $file;
    }

    public function getWebPath($file = null)
    {
        $dir = str_replace(DIRECTORY_SEPARATOR, '/', $this->getUploadDir());
        return null === $file ? '/' . $this->getUploadDir() : $dir . '/' . $file;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return getcwd() . DIRECTORY_SEPARATOR . $this->getUploadDir();
    }

    public function getMediaDir()
    {
        return __DIR__ . '/../../../../web';
    }

    protected function getUploadDir()
    {
        return 'mediafile' . DIRECTORY_SEPARATOR . 'banner' . DIRECTORY_SEPARATOR . $this->getHash();
    }


    public function generateRandomString($length = 22)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    public function generateReadableRandomString($length = 12)
    {
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }


    public function setFile(UploadedFile $photoFile)
    {
        $this->file = $photoFile;
        $this->photo = str_replace(" ", "_", $photoFile->getClientOriginalName());
        try {
            if (is_object($this->file)) {
                $this->file->move($this->getUploadDir(), $this->photo);
                unset($this->file);
            }
        } catch (\Exception $e) {

        }

        return $this;
    }

    public function getKind()
    {
        if (self::BANNER_TYPE_VIDEO == $this->type)
            return 'video';
        else return 'image';
    }

    public function getFileAsset(){
        return $this->getWebPath($this->photo);
    }

    public function getTitleArray(){
        $titles = explode(',', $this->getName());
        return $titles;
    }
}
