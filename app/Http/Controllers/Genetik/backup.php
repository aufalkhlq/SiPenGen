// public function generateSchedule(Request $request)
    // {
    //     // Validate request input if needed


    //     // Initialize genetic algorithm
    //     $geneticAlgorithm = new GeneticAlgorithm();

    //     // Define population size and number of generations
    //     $populationSize = 10; // Number of schedules in each generation
    //     $maxGenerations = 100; // Maximum number of generations

    //     // Run genetic algorithm to generate schedule
    //     $schedules = $geneticAlgorithm->run($populationSize, $maxGenerations);

    //     // Save generated schedule to database
    //     $geneticAlgorithm->saveJadwal($schedules);

    //     // Return success response
    //     return response()->json([
    //         'success' => 'Schedule generated successfully',
    //         'schedules' => $schedules,
    //     ]);
    // }

    // /**
    //  * Get all schedules.
    //  */
    // public function getSchedules()
    // {
    //     $geneticAlgorithm = new GeneticAlgorithm();
    //     $schedules = $geneticAlgorithm->getSchedule();

    //     return response()->json([
    //         'success' => 'Schedules retrieved successfully',
    //         'schedules' => $schedules,
    //     ]);
    // }

    // /**
    //  * Clear all schedules.
    //  */
    // public function clearSchedules()
    // {
    //     Jadwal::truncate();

    //     return response()->json([
    //         'success' => 'Schedules cleared successfully',
    //     ]);







        // public function generateSchedule()
        // {
        //     $geneticAlgorithm = new GeneticAlgorithm();

        //     // Set your desired population size and maximum number of generations
        //     $populationSize = 100;
        //     $maxGenerations = 50;

        //     // Run the genetic algorithm
        //     $schedules = $geneticAlgorithm->run($populationSize, $maxGenerations);

        //     // Save the generated schedules
        //     $geneticAlgorithm->saveJadwal($schedules);

        //     // Return the schedules
        //     return response()->json($schedules);
        // }

        // public function getSchedule()
        // {
        //     $geneticAlgorithm = new GeneticAlgorithm();

        //     // Get the schedules
        //     $schedules = $geneticAlgorithm->getJadwal();

        //     // Return the schedules
        //     return response()->json($schedules);
        // }

        // public function clearSchedule()
        // {
        //     $geneticAlgorithm = new GeneticAlgorithm();

        //     // Clear the schedules
        //     $geneticAlgorithm->clearJadwal();

        //     // Return a success message
        //     return response()->json(['message' => 'Schedules cleared successfully']);
        // }

        // public function generateSchedule(Request $request)
        // {
        //     $geneticAlgorithm = new GeneticAlgorithm();
        //     $populationSize = $request->input('population_size', 100);
        //     $maxGenerations = $request->input('max_generations', 100);

        //     $schedules = $geneticAlgorithm->runGeneticAlgorithm($populationSize, $maxGenerations);

        //     // Save schedules to database
        //     $geneticAlgorithm->saveSchedule($schedules);

        //     return response()->json(['message' => 'Schedule generated successfully'], 200);
        // }

        // public function viewSchedule()
        // {
        //     $schedules = Jadwal::all();

        //     return response()->json(['schedules' => $schedules], 200);
        // }

        // public function clearSchedule()
        // {
        //     Jadwal::truncate();

        //     return response()->json(['message' => 'Schedule cleared successfully'], 200);
        // }
