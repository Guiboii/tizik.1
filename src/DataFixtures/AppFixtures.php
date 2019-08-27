<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\City;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\School;
use App\Entity\Discipline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    //création des roles
    public function load(ObjectManager $manager)
    {
        $adminRole = new Role();
        $adminRole  ->setTitle('ROLE_ADMIN')
                    ->setDescription('Administrateur');
            $manager->persist($adminRole);
        $teacherRole = new Role();
        $teacherRole->setTitle('ROLE_TEACHER')
                    ->setDescription('Enseignant');
            $manager->persist($teacherRole);
        $studentRole = new Role();
        $studentRole->setTitle('ROLE_STUDENT')
                    ->setDescription('Etudiant');
        $manager->persist($studentRole);
        $parentRole = new Role();
        $parentRole->setTitle('ROLE_HOUSEHOLD')
                    ->setDescription('Foyer');
        $manager->persist($parentRole);

        //création d'utilisateurs test
        $adminUser = new User();
        $adminUser  ->setFirstName('Guillaume')
                    ->setLastName('Hamet')
                    ->setEmail('admin@tizik.com')
                    ->setPicture('https://avatars3.githubusercontent.com/u/40663377?s=400&u=03c1cf6d2b38512a8b7ff0f616afa460236aa12a&v=4')
                    ->setUsername('admin')
                    ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                    ->addUserRole($adminRole)
                    ->setValidation(TRUE);
            $manager->persist($adminUser);

        $teacherUser = new User();
        $teacherUser->setFirstName('Teacher')
                    ->setLastName('Teacher')
                    ->setEmail('teacher@tizik.com')
                    ->setPicture('https://randomuser.me/api/portraits/1')
                    ->setUsername('teacher')
                    ->setHash($this->encoder->encodePassword($teacherUser, 'password'))
                    ->addUserRole($teacherRole)
                    ->setValidation(TRUE);
            $manager->persist($teacherUser);

        //création du compte student
        $studentUser = new User();
        $studentUser->setFirstName('Student')
                    ->setLastName('Student')
                    ->setEmail('student@tizik.com')
                    ->setPicture('https://randomuser.me/api/portraits/1')
                    ->setUsername('student')
                    ->setHash($this->encoder->encodePassword($studentUser, 'password'))
                    ->addUserRole($studentRole)
                    ->setValidation(TRUE);
        $manager->persist($studentUser);

        $manager->flush();
    }

    /* public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');
        $cities = $this->schools($manager, $faker);

        //création des disciplines
        $hautbois = new Discipline();
        $hautbois   ->setTitle('Hautbois')
                    ->setType('instrument');
            $manager->persist($hautbois);
        $saxophone = new Discipline();
        $saxophone  ->setTitle('Saxophone')
                    ->setType('instrument');
            $manager->persist($saxophone);
        $clarinette = new Discipline();
        $clarinette ->setTitle('Clarinette')
                    ->setType('instrument');
            $manager->persist($clarinette);
        $flute = new Discipline();
        $flute  ->setTitle('Flûte')
                ->setType('instrument');
            $manager->persist($flute);
        $FM = new Discipline();
        $FM ->setTitle('FM')
            ->setType('érudition');
            $manager->persist($FM);
        $orchestre = new Discipline();
        $orchestre  ->setTitle('Orchestre')
                    ->setType('collectif');
            $manager->persist($orchestre);
        $epo = new Discipline();
        $epo    ->setTitle('EpO')
                ->setType('collectif');
            $manager->persist($epo);

        //création des rôles
        $adminRole = new Role();
        $adminRole  ->setTitle('ROLE_ADMIN')
                    ->setDescription('Administrateur');
            $manager->persist($adminRole);
        $teacherRole = new Role();
        $teacherRole->setTitle('ROLE_TEACHER')
                    ->setDescription('Enseignant');
            $manager->persist($teacherRole);
        $studentRole = new Role();
        $studentRole->setTitle('ROLE_STUDENT')
                    ->setDescription('Etudiant');
        $manager->persist($studentRole);
        $parentRole = new Role();
        $parentRole->setTitle('ROLE_PARENT')
                    ->setDescription('Parent');
        $manager->persist($parentRole);

        //création du compte admin
        $adminUser = new User();
        $adminUser  ->setFirstName('Guillaume')
                    ->setLastName('Hamet')
                    ->setEmail('guigui@tizik.com')
                    ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                    ->setPicture('https://lh3.googleusercontent.com/-kka8cqNXrEE/UJJ2pUvRTrI/AAAAAAAAAQk/OVut-hzHg_cOi5scyrf-ZoJEOoPZtLyJACEwYBhgL/w106-h140-p/IMG_0170%2Bcopy.jpg')
                    ->addUserRole($adminRole);
        $manager->persist($adminUser);

        //création du compte teacher
        $teacherUser = new User();
        $teacherUser  ->setFirstName('Teacher')
                    ->setLastName('Teacher')
                    ->setEmail('teacher@tizik.com')
                    ->setHash($this->encoder->encodePassword($teacherUser, 'password'))
                    ->setPicture('https://randomuser.me/api/portraits/1')
                    ->addUserRole($teacherRole);
        $manager->persist($teacherUser);

        //création du compte student
        $studentUser = new User();
        $studentUser  ->setFirstName('Student')
                    ->setLastName('Student')
                    ->setEmail('student@tizik.com')
                    ->setHash($this->encoder->encodePassword($studentUser, 'password'))
                    ->setPicture('https://randomuser.me/api/portraits/1')
                    ->addUserRole($studentRole);
        $manager->persist($studentUser);


        // Création des utilisateurs
        $users = [];
        $genres = ['male', 'female' ];

        for($i = 1; $i <= 30; $i++) {
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';
            
            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstName($genre))
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setHash($hash)
                ->setPicture($picture);

            $manager->persist($user);
            $users[] = $user;

        }

        //création des écoles
        $schools = [];
        for($i = 1; $i <= 10; $i++) {
            $school = new School();

            $title = $faker->company();
            $address = $faker->streetAddress();
            
            $school ->setTitle($title)
                    ->setAddress($address);

             $manager->persist($school);
             $schools[] = $school;
        }

        //répartition des écoles dans les villes
        for ($i=0; $i <= 9; $i++)
        {
            $school = $schools[mt_rand(0, 9)];
            $city = $cities[mt_rand(0, count($cities)-1)];
            //print_r($city);
            $school ->setVille($city);
        }

        //répartition des utilisateurs dans les écoles

        for ($i = 0; $i <= 19; $i++)
        {
            $user = $users[mt_rand(0, 9)];
            $schoolid = $schools[mt_rand(0, count($schools) -1)];
            //print_r($schoolid);
            $user   ->addSchool($schoolid)
                    ->addUserRole($teacherRole);
        }

        for ($i = 0; $i <= 9; $i++)
        {
            $user = $users[mt_rand(10, 29)];
            $schoolid = $schools[mt_rand(0, count($schools) -1)];
            $user   ->addSchool($schoolid)
                    ->addUserRole($studentRole);
        }

        $manager->flush();
    }*/

}
