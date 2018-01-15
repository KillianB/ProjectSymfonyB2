<?php
/**
 * Created by IntelliJ IDEA.
 * User: Malo
 * Date: 04/01/2018
 * Time: 15:40
 */

namespace AppBundle\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class LogsController extends Controller
{
    /**
     * @Route("/listeLog/", name="list_logs")
     */
    public function listLogFiles() {
        $finder = new Finder();
        $finder->files()->in(dirname(__DIR__)."/../../var/logs")->name("*.log");

        return $this->render('Logs/logs.html.twig', array(
            'finder' => $finder
        ));
    }

    /**
     * @Route("/listeLog/{logFileName}", name="display_log")
     */
    public function displayLogFile($logFileName) {
        $finder = new Finder();
        $finder->files()->in(dirname(__DIR__)."/../../var/logs")->name("*.log");

        $content = "";

        foreach($finder as $file) {
            if ($file->getRelativePathname() == $logFileName) {
                $content = $file->getContents();
                break;
            }
        }

        $content = trim($content);
        $textAr = explode("[]", $content);
        $textAr = array_filter($textAr, 'trim');

        foreach($textAr as $line){
            $line .= "\n\n\n";
        }

        return $this->render('Logs/logs.html.twig', array(
            'content' => $textAr,
            'file' => $file,
            'finder' => $finder
        ));
    }


    // Fonction inutilisée !
    /**
     * @Route("/listeLog/add/{fileToCreate}", name="create_log")
     */
    public function addLogFile($fileToCreate) {
        $fs = new FileSystem();

        try {
            if(!$fs->exists(dirname(__DIR__)."/../../var/logs" . $fileToCreate)) {
                $fs->touch(dirname(__DIR__)."/../../var/logs" . $fileToCreate);
            } else {
                $fs->touch(dirname(__DIR__)."/../../var/logs" . $fileToCreate);
            }
        } catch(IOExceptionInterface $e) {
            echo "Erreur de creation du fichier (chemin d'accès : ".$e->getPath().")";
        }
    }

    /**
     * @Route("/listeLog/empty/{fileToEmpty}", name="empty_log")
     */
    public function emptyLogFile($fileToEmpty, LoggerInterface $logger) {
        file_put_contents(dirname(__DIR__)."/../../var/logs/".$fileToEmpty, "");

        $logger->warning("Le fichier ".$fileToEmpty." a été vidé de son contenu.");

        return $this->redirectToRoute('display_log', array('logFileName' => $fileToEmpty));
    }
}