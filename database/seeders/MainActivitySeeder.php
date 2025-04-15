<?php

namespace Database\Seeders;

use App\Models\Initiative;
use App\Models\MainActivity;
use App\Models\MeasuringUnit;
use App\Models\Objective;
use App\Models\Plan;
use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $mainActivities = MainActivity::factory(128)->create();

        $unit = Unit::where('name', 'Health System Innovation & Quality')->first();

        $fiscalYearRecord = FiscalYear::where('name', '2023-2024')->first();

        if (!$fiscalYearRecord) {
            $this->command->error('Fiscal Year 2023-2024 does not exist!');
            return;
        }

        foreach ($mainActivities as $value) {
            Plan::updateOrCreate([
                'main_activity_id' => $value->id,
                'unit_id' => $unit->id,
            ],
            [
                'fiscal_year_id' => $fiscalYearRecord->id,
            ]);
        }
        $objective1 = Objective::updateOrCreate([
            'title' => 'Harnessing Innovation for Health System Quality, Equity, and Safety',
        ]);

        $Initiative1 = Initiative::updateOrCreate([
            'title' => 'Strengthen the health innovation program',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity = MainActivity::updateOrCreate([
            'title' => 'Monitor and Support the implementation of health innovation Guideline',
            'initiative_id' => $Initiative1->id,
            'target' => 4.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.5,
        ]);


        $mainActivity2 = MainActivity::updateOrCreate([
            'title' => ' Conduct National Health Innovation Think Tank Group idea generation meetings',
            'initiative_id' => $Initiative1->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 1.0,
        ]);

        $mainActivity3 = MainActivity::updateOrCreate([
            'title' => 'Conduct Advocacy on national innovation demand articulation and ecosystem mapping document',
            'initiative_id' => $Initiative1->id,
            'target' => 1,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.5,
        ]);

        $mainActivity4 = MainActivity::updateOrCreate([
            'title' => 'Finalize and launch the National Health Innovation Strategy document',
            'initiative_id' => $Initiative1->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.8,
        ]);

        $mainActivity5 = MainActivity::updateOrCreate([
            'title' => 'Finalize Web-based health innovation repository application',
            'initiative_id' => $Initiative1->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 1.0,
        ]);

        $mainActivity6 = MainActivity::updateOrCreate([
            'title' => 'Establish National health innovation lab in Ministry of Health',
            'initiative_id' => $Initiative1->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.8,
        ]);

        $mainActivity7 = MainActivity::updateOrCreate([
            'title' => 'Supporting the establishment of health innovation labs at the RHB',
            'initiative_id' => $Initiative1->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 1.0,
        ]);


        $Initiative2 = Initiative::updateOrCreate([
            'title' => 'Strengthen health innovation learning and knowledge transfer',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity8 = MainActivity::updateOrCreate([
            'title' => 'Develop  National Health innovation training package and get approval from CPD',
            'initiative_id' => $Initiative2->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.5,
        ]);

        $mainActivity9 = MainActivity::updateOrCreate([
            'title' => 'Provide  Health innovation  training for  professional from RHBs and Innovation & Quality (IQ)  hubs',
            'initiative_id' => $Initiative2->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.5,
        ]);

        $mainActivity10 = MainActivity::updateOrCreate([
            'title' => 'Conduct Global annual  Health Innovation and Quality Summit in collaboration with World Health Organization',
            'initiative_id' => $Initiative2->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.300,
        ]);

        $mainActivity11 = MainActivity::updateOrCreate([
            'title' => 'Strengthen partnership and cooperation through establishing Innovation Networking program',
            'initiative_id' => $Initiative2->id,
            'target' => 42.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.100,
        ]);

        $mainActivity12 = MainActivity::updateOrCreate([
            'title' => 'Identify and  initiate pilot testing of Demand driven Health Innovation projects',
            'initiative_id' => $Initiative2->id,
            'target' => 4.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.100,
        ]);

        $mainActivity13 = MainActivity::updateOrCreate([
            'title' => ' Provide competitive Grants for potential health innovations projects',
            'initiative_id' => $Initiative2->id,
            'target' => 4.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.200,
        ]);

        $mainActivity14 = MainActivity::updateOrCreate([
            'title' => 'Recognize High impact health innovation projects on competition based selection',
            'initiative_id' => $Initiative2->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.200,
        ]);

        $Initiative3 = Initiative::updateOrCreate([
            'title' => 'Implement PHCU-SBFR Pilot Project Implementation',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity15 = MainActivity::updateOrCreate([
            'title' => 'Provide Onsite technical support for  PHCU -SBFR sites',
            'initiative_id' => $Initiative3->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.300,
        ]);

        $mainActivity16 = MainActivity::updateOrCreate([
            'title' => 'Conduct night sudden supervision visit in the targeted PHCU-SBFR sites',
            'initiative_id' => $Initiative3->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.100,
        ]);

        $mainActivity17 = MainActivity::updateOrCreate([
            'title' => 'Support the implementation of digitalization of activities in the  targeted PHCU-SBFR sites',
            'initiative_id' => $Initiative3->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.125,
        ]);

        $mainActivity18 = MainActivity::updateOrCreate([
            'title' => 'Conduct Woreda based PHCU-SBFR learning and experience sharing program',
            'initiative_id' => $Initiative3->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 1.175,
        ]);

        $mainActivity19 = MainActivity::updateOrCreate([
            'title' => 'Conduct PHCU-SBFR performance review meetings',
            'initiative_id' => $Initiative3->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 1.600,
        ]);



        $Initiative4 = Initiative::updateOrCreate([
            'title' => 'Strengthen Hospital- SBFR Project Implementation',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity20 = MainActivity::updateOrCreate([
            'title' => 'Providing on-site technical support for Hospital- SBFR  implementation',
            'initiative_id' => $Initiative4->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.200,
        ]);

        $mainActivity21 = MainActivity::updateOrCreate([
            'title' => 'Conducting night sudden supervision visit in the targeted  Hospital-SBFR  implementation sites',
            'initiative_id' => $Initiative4->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.200,
        ]);

        $mainActivity22 = MainActivity::updateOrCreate([
            'title' => 'Support digitalization activities for Hospital-SBFR implementation sites',
            'initiative_id' => $Initiative4->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.200,
        ]);

        $mainActivity23 = MainActivity::updateOrCreate([
            'title' => 'Conduct learning and experience sharing  among Hospital-SBFR implementing sites',
            'initiative_id' => $Initiative4->id,
            'target' => 6.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.200,
        ]);

        $mainActivity24 = MainActivity::updateOrCreate([
            'title' => 'Conducting national Hospital-SBFR performance review meeting and provide recognition for best performers',
            'initiative_id' => $Initiative4->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.200,
        ]);

        $mainActivity25 = MainActivity::updateOrCreate([
            'title' => 'Develop performance audit tool and conduct performance evaluation using the audit tool',
            'initiative_id' => $Initiative4->id,
            'target' => 4.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.460,
        ]);

        $mainActivity26 = MainActivity::updateOrCreate([
            'title' => 'Develop Second phase Hospital-SBFR  Value based care project document',
            'initiative_id' => $Initiative4->id,
            'target' => 4.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.160,
        ]);

        $mainActivity27 = MainActivity::updateOrCreate([
            'title' => 'Launch the second phase Hospital-SBFR  Value based care project',
            'initiative_id' => $Initiative4->id,
            'target' => 4.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.400,
        ]);

        $Initiative5 = Initiative::updateOrCreate([
            'title' => ' Enhance Integration and coordination  of  the National Healthcare quality and safety strategy Implementation ',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity28 = MainActivity::updateOrCreate([
            'title' => 'Support the integrated implementation of the National Health care quality and safety strategy II',
            'initiative_id' => $Initiative5->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.300,
        ]);

        $mainActivity29 = MainActivity::updateOrCreate([
            'title' => 'Conduct the national Healthcare Innovation and Quality Steering Committee meeting',
            'initiative_id' => $Initiative5->id,
            'target' => 4.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.160,
        ]);

        $mainActivity30 = MainActivity::updateOrCreate([
            'title' => 'Conduct  Moh and RHB Joint Quality and Equity Forum (JQEF) to support NQSS-II and NHES-I implementation',
            'initiative_id' => $Initiative5->id,
            'target' => 2.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.160,
        ]);

        $mainActivity31 = MainActivity::updateOrCreate([
            'title' => 'Conduct  quality improvement mentorship and coaching support  for RHBs, innovation and quality hubs and SBFR sites',
            'initiative_id' => $Initiative5->id,
            'target' => 3.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.460,
        ]);

        $mainActivity32 = MainActivity::updateOrCreate([
            'title' => 'Conduct  Healthcare Quality community of Practice forum',
            'initiative_id' => $Initiative5->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.260,
        ]);

        $Initiative6 = Initiative::updateOrCreate([
            'title' => 'Improve evidence-based and  Patient-centered care provision',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity33 = MainActivity::updateOrCreate([
            'title' => 'Develop user experience measurement tool',
            'initiative_id' => $Initiative6->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.060,
        ]);

        $mainActivity34 = MainActivity::updateOrCreate([
            'title' => 'Incorporate clinical and mortality audit  tools  in the existing  quality improvement training Package',
            'initiative_id' => $Initiative6->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.120,
        ]);

        $mainActivity35 = MainActivity::updateOrCreate([
            'title' => 'Provide monitoring and  implementation support on the use of pediatric and surgical mortality Audit for Quality Improvement in the IQ hub and Hospital SBFR sites',
            'initiative_id' => $Initiative6->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.060,
        ]);

        $mainActivity36 = MainActivity::updateOrCreate([
            'title' => 'conduct Pilot implementation of the national Effective Coverage in the selected districts and Health facilities',
            'initiative_id' => $Initiative6->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.279,
        ]);

        $mainActivity37 = MainActivity::updateOrCreate([
            'title' => 'Finalize, endorse and disseminate Effective coverage Guideline',
            'initiative_id' => $Initiative6->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.279,
        ]);


        $Initiative7 = Initiative::updateOrCreate([
            'title' => 'Strengthen continuous learning and quality improvement to establish a culture of health service quality and safety',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity38 = MainActivity::updateOrCreate([
            'title' => 'Provide technical and financial support to strengthen health care innovation and quality learning hubs',
            'initiative_id' => $Initiative7->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.279,
        ]);

        $mainActivity39 = MainActivity::updateOrCreate([
            'title' => 'Provide technical and financial support for RHBs to conduct  Health innovation and quality summit',
            'initiative_id' => $Initiative7->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.279,
        ]);

        $mainActivity40 = MainActivity::updateOrCreate([
            'title' => 'Provide need-based quality improvement training to RHBs, Hospitals and Health centers',
            'initiative_id' => $Initiative7->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.279,
        ]);


        $Initiative8 = Initiative::updateOrCreate([
            'title' => 'Strengthen the implementation of the  National accreditation program',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity41 = MainActivity::updateOrCreate([
            'title' => 'Providing technical and financial support for the readiness of Health facilities for accreditation',
            'initiative_id' => $Initiative8->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.279,
        ]);

        $mainActivity42 = MainActivity::updateOrCreate([
            'title' => 'Provide technical support on the development of Accreditation Surveyor Training Manual',
            'initiative_id' => $Initiative8->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.279,
        ]);

        $mainActivity43 = MainActivity::updateOrCreate([
            'title' => 'Finalize the development of the accreditation incentive package',
            'initiative_id' => $Initiative8->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.950,
        ]);

        $mainActivity44 = MainActivity::updateOrCreate([
            'title' => 'Digitizing the Accreditation Program Support System',
            'initiative_id' => $Initiative8->id,
            'target' => 100,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Percentage')->first()->id,
            'weight' => 0.500,
        ]);

        $mainActivity45 = MainActivity::updateOrCreate([
            'title' => 'Conduct high level advocacy workshop for the senior management of healthcare facilities and other stakeholders on the implementation of the accreditation standard',
            'initiative_id' => $Initiative8->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.250,
        ]);

        $mainActivity46 = MainActivity::updateOrCreate([
            'title' => 'Conduct national launching ceremony on accreditation standard implementation',
            'initiative_id' => $Initiative8->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.250,
        ]);

        $mainActivity47 = MainActivity::updateOrCreate([
            'title' => 'Provide technical support to health facility readiness for the implementation of  the accreditation standard program',
            'initiative_id' => $Initiative8->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.125,
        ]);

        $Initiative9 = Initiative::updateOrCreate([
            'title' => 'Strengthening healthcare Safety Program',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity48 = MainActivity::updateOrCreate([
            'title' => 'Conduct national launching workshop on patient safety management Guideline and Safe care align project.',
            'initiative_id' => $Initiative9->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.025,
        ]);

        $mainActivity49 = MainActivity::updateOrCreate([
            'title' => 'Provide ToT  on patient safety',
            'initiative_id' => $Initiative9->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.525,
        ]);

        $mainActivity50 = MainActivity::updateOrCreate([
            'title' => 'Incorporate patient safety training packages to e-learning platform',
            'initiative_id' => $Initiative9->id,
            'target' => 2.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.425,
        ]);

        $mainActivity51 = MainActivity::updateOrCreate([
            'title' => 'Provide Patient safety incident reporting and learning system in IQ hubs and  SBFR sites',
            'initiative_id' => $Initiative9->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.425,
        ]);

        $mainActivity52 = MainActivity::updateOrCreate([
            'title' => 'Conduct patient safety mentorship and coaching support',
            'initiative_id' => $Initiative9->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.425,
        ]);

        $mainActivity53 = MainActivity::updateOrCreate([
            'title' => 'Conduct Annual Patient Safety Day celebration at the national level',
            'initiative_id' => $Initiative9->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.500,
        ]);

        $Initiative10 = Initiative::updateOrCreate([
            'title' => 'Strengthening Infection Prevention and Control program Implementation',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity54 = MainActivity::updateOrCreate([
            'title' => 'Strengthen IPC  Centers of Excellence program implementation in the selected hospitals',
            'initiative_id' => $Initiative10->id,
            'target' => 2.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.250,
        ]);

        $mainActivity55 = MainActivity::updateOrCreate([
            'title' => 'Provide technical support for selected pilot Healthcare facilities in the implementation of Healthcare Acquired infection surveillance(HAI).',
            'initiative_id' => $Initiative10->id,
            'target' => 2.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.250,
        ]);

        $mainActivity56 = MainActivity::updateOrCreate([
            'title' => 'Finalize and Implement IPC Facility level assessment tool (IPC- FLAT ) in the health facilities',
            'initiative_id' => $Initiative10->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.300,
        ]);

        $mainActivity57 = MainActivity::updateOrCreate([
            'title' => 'Support the integration of IPC  education and training in the health sciences pre-service curricula',
            'initiative_id' => $Initiative10->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.950,
        ]);

        $mainActivity58 = MainActivity::updateOrCreate([
            'title' => 'Provide  Advanced IPC training for the second cohort trainee\'s',
            'initiative_id' => $Initiative10->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.250,
        ]);

        $mainActivity59 = MainActivity::updateOrCreate([
            'title' => 'Providing need based IPC training to  implementing sites',
            'initiative_id' => $Initiative10->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.500,
        ]);

        $mainActivity60 = MainActivity::updateOrCreate([
            'title' => 'Undertake Health care-associated infection (HAI) surveillance data aggregation and analysis and provide feedback accordingly',
            'initiative_id' => $Initiative10->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.250,
        ]);

        $mainActivity61 = MainActivity::updateOrCreate([
            'title' => 'Monitoring healthcare facilities on infection prevention and control program',
            'initiative_id' => $Initiative10->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.600,
        ]);

        $mainActivity62 = MainActivity::updateOrCreate([
            'title' => 'Organize best experience sharing programs among healthcare facilities implementing HAIs surveillance system',
            'initiative_id' => $Initiative10->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.400,
        ]);

        $mainActivity63 = MainActivity::updateOrCreate([
            'title' => 'Conduct National IPC Advocacy and  Annual Performance Review meetings',
            'initiative_id' => $Initiative10->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.400,
        ]);



        $Initiative11 = Initiative::updateOrCreate([
            'title' => 'Strengthening Learning and Knowledge management',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity64 = MainActivity::updateOrCreate([
            'title' => 'Finalize  I-LEQS project document',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.400,
        ]);

        $mainActivity65 = MainActivity::updateOrCreate([
            'title' => 'Establishing  research and advisory committee for innovation and  quality (IQ-RAC)',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.400,
        ]);

        $mainActivity66 = MainActivity::updateOrCreate([
            'title' => 'Conducting IQ-RAC consultative workshop',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.400,
        ]);

        $mainActivity67 = MainActivity::updateOrCreate([
            'title' => 'Conducting a workshop for identifying strategic directions and planing on IQ-RAC',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.950,
        ]);

        $mainActivity68 = MainActivity::updateOrCreate([
            'title' => 'Conduct monthly IQ RAC meetings',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.500,
        ]);

        $mainActivity69 = MainActivity::updateOrCreate([
            'title' => 'Conducting  peer learning and knowledge transfer  sessions (Abrehot) on monthly basis',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.500,
        ]);

        $mainActivity70 = MainActivity::updateOrCreate([
            'title' => 'Provide feedback on selected indicators of quality and equity for MOH, RHB and IQ hubs',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.250,
        ]);

        $mainActivity71 = MainActivity::updateOrCreate([
            'title' => 'Developing and implementing electronic dashboards at HSQI LEO and  in learning facilities using key performance indicators',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.250,
        ]);

        $mainActivity72 = MainActivity::updateOrCreate([
            'title' => 'Conducting capacity building training for the HSQI LEO staff members',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.250,
        ]);

        $mainActivity73 = MainActivity::updateOrCreate([
            'title' => 'Providing training for regional and SBFR hospitals on data quality and information use',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.250,
        ]);

        $mainActivity74 = MainActivity::updateOrCreate([
            'title' => 'Conducting I-LEQS integrated supporting  supervision  visits',
            'initiative_id' => $Initiative11->id,
            'target' => 1.0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0.300,
        ]);

        $mainActivity75 = MainActivity::updateOrCreate([
            'title' => 'Developing and distributing policy briefs and research finding issue briefs',
            'initiative_id' => $Initiative11->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity76 = MainActivity::updateOrCreate([
            'title' => 'Organize  policy dialogues and consultation workshops',
            'initiative_id' => $Initiative11->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity77 = MainActivity::updateOrCreate([
            'title' => 'Produce National Health Equity status annual report',
            'initiative_id' => $Initiative11->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity78 = MainActivity::updateOrCreate([
            'title' => 'Conducing I-LEQS Performance review meeting',
            'initiative_id' => $Initiative11->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);


        $Initiative12 = Initiative::updateOrCreate([
            'title' => 'Strengthening health equity Implementation and Measurement',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity79 = MainActivity::updateOrCreate([
            'title' => 'Conducting integrated monitoring and support on the social determinant of health(SDH) project',
            'initiative_id' => $Initiative12->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity80 = MainActivity::updateOrCreate([
            'title' => 'Conducting end term evaluation of the social determinant of health(SDH) project',
            'initiative_id' => $Initiative12->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity81 = MainActivity::updateOrCreate([
            'title' => 'Conduct  social determinant of health(SDH) project steering committee meeting',
            'initiative_id' => $Initiative12->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity82 = MainActivity::updateOrCreate([
            'title' => 'Providing budgetary support for the regional implementation of health equity strategy implementation',
            'initiative_id' => $Initiative12->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity83 = MainActivity::updateOrCreate([
            'title' => 'Finalize the National Health equity monitoring and improvement Guide',
            'initiative_id' => $Initiative12->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity84 = MainActivity::updateOrCreate([
            'title' => 'Organize Launching workshop  of  the National Health equity monitoring and improvement Guide',
            'initiative_id' => $Initiative12->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity85 = MainActivity::updateOrCreate([
            'title' => 'Develop health Equity training Manual',
            'initiative_id' => $Initiative12->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);


        $Initiative13 = Initiative::updateOrCreate([
            'title' => 'Improve Mobile Health Service provision and other innovation modalities',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity86 = MainActivity::updateOrCreate([
            'title' => 'Developing  mobile health training manual',
            'initiative_id' => $Initiative13->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity87 = MainActivity::updateOrCreate([
            'title' => 'Revise and standardize mobile health services  basic medical supplies list (kit)',
            'initiative_id' => $Initiative13->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity88 = MainActivity::updateOrCreate([
            'title' => 'Conducting procurement of the basic medical supplies for mobile health services',
            'initiative_id' => $Initiative13->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity89 = MainActivity::updateOrCreate([
            'title' => 'Digitize Mobile health team services',
            'initiative_id' => $Initiative13->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity90 = MainActivity::updateOrCreate([
            'title' => 'Conducting experiences sharing  and review meeting on mobile health services provision',
            'initiative_id' => $Initiative13->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity91 = MainActivity::updateOrCreate([
            'title' => 'Monitor and support Mobile health services implementation',
            'initiative_id' => $Initiative13->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $Initiative14 = Initiative::updateOrCreate([
            'title' => 'Implement Health Equity Leveling Up Project(HELP)',
            'objective_id' => $objective1->id,
        ]);

        $mainActivity92 = MainActivity::updateOrCreate([
            'title' => 'Finalizing Health Equity Leveling Up Program(HELP)  document',
            'initiative_id' => $Initiative14->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity93 = MainActivity::updateOrCreate([
            'title' => 'Launching health equity leveling program document',
            'initiative_id' => $Initiative14->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity94 = MainActivity::updateOrCreate([
            'title' => 'Conducing monitoring and support for the health equity leveling program',
            'initiative_id' => $Initiative14->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity95 = MainActivity::updateOrCreate([
            'title' => 'Conducting health equity leveling program review meeting',
            'initiative_id' => $Initiative14->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);


        $objective2 = Objective::updateOrCreate([
            'title' => 'Improve Health system capacity and regulation',
        ]);


        $Initiative15 = Initiative::updateOrCreate([
            'title' => 'Strengthen implementation of High Impact Leadership Program for Health-HIL-PH',
            'objective_id' => $objective2->id,
        ]);

        $mainActivity96 = MainActivity::updateOrCreate([
            'title' => 'Developing and implementing high impact leadership program indicators',
            'initiative_id' => $Initiative15->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity97 = MainActivity::updateOrCreate([
            'title' => 'Design and implement 360 degree evaluation tool',
            'initiative_id' => $Initiative15->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity98 = MainActivity::updateOrCreate([
            'title' => 'Develop and implement a coaching guideline for health leaders',
            'initiative_id' => $Initiative15->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity99 = MainActivity::updateOrCreate([
            'title' => 'Develop and implement health leaders selection, certification, and recognition guideline',
            'initiative_id' => $Initiative15->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity100 = MainActivity::updateOrCreate([
            'title' => 'Digitized and integrate high impact leadership training materials into an e-learning platform',
            'initiative_id' => $Initiative15->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity101 = MainActivity::updateOrCreate([
            'title' => 'Develop and implement high impact leadership training program database',
            'initiative_id' => $Initiative15->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity102 = MainActivity::updateOrCreate([
            'title' => 'Conduct annual national health leaders forum',
            'initiative_id' => $Initiative15->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $Initiative16 = Initiative::updateOrCreate([
            'title' => 'Enhance the  implementation capacity of strategic,mid-level and frontline health leaders',
            'objective_id' => $objective2->id,
        ]);

        $mainActivity103 = MainActivity::updateOrCreate([
            'title' => 'Getting approval of High impact leadership program from CPD',
            'initiative_id' => $Initiative16->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity104 = MainActivity::updateOrCreate([
            'title' => 'Provide TOT for strategic health leaders',
            'initiative_id' => $Initiative16->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity105 = MainActivity::updateOrCreate([
            'title' => 'Provide training for first cohort of Strategic leaders',
            'initiative_id' => $Initiative16->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity106 = MainActivity::updateOrCreate([
            'title' => 'Provide ToT for Mid and frontline health leaders',
            'initiative_id' => $Initiative16->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity107 = MainActivity::updateOrCreate([
            'title' => 'Provide training for first cohort of mid-level leaders',
            'initiative_id' => $Initiative16->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity108 = MainActivity::updateOrCreate([
            'title' => 'Provide training for first cohort of frontline leaders',
            'initiative_id' => $Initiative16->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);


        $Initiative17 = Initiative::updateOrCreate([
            'title' => 'Empower women\'s in health leadership ',
            'objective_id' => $objective2->id,
        ]);

        $mainActivity109 = MainActivity::updateOrCreate([
            'title' => 'Develop Women in Health Leadership training manual and getting approval from CPD',
            'initiative_id' => $Initiative17->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);


        $mainActivity110 = MainActivity::updateOrCreate([
            'title' => 'Provide TOT for Women\'s in Health leadership',
            'initiative_id' => $Initiative17->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);


        $Initiative18 = Initiative::updateOrCreate([
            'title' => 'Improve Health System Managerial Accountability',
            'objective_id' => $objective2->id,
        ]);


        $mainActivity111 = MainActivity::updateOrCreate([
            'title' => 'Provide training on managerial accountability system',
            'initiative_id' => $Initiative18->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);



        $mainActivity112 = MainActivity::updateOrCreate([
            'title' => 'Finalizing indicators for managerial accountability system',
            'initiative_id' => $Initiative17->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity113 = MainActivity::updateOrCreate([
            'title' => 'Digitizing managerial accountability system indicators',
            'initiative_id' => $Initiative17->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity114 = MainActivity::updateOrCreate([
            'title' => 'Follow and support  implementation of managerial accountability in 55 words',
            'initiative_id' => $Initiative17->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity115 = MainActivity::updateOrCreate([
            'title' => 'Conducting performance review meeting on managerial accountability',
            'initiative_id' => $Initiative17->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);


        $Initiative19 = Initiative::updateOrCreate([
            'title' => 'Strengthen leadership incubation program (LIP)',
            'objective_id' => $objective2->id,
        ]);

        $mainActivity116 = MainActivity::updateOrCreate([
            'title' => 'Provide 7th round LIP training',
            'initiative_id' => $Initiative19->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity117 = MainActivity::updateOrCreate([
            'title' => 'Provide coaching and shadowing expertise for LIP',
            'initiative_id' => $Initiative19->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity118 = MainActivity::updateOrCreate([
            'title' => 'Conduct experience sharing and practical program application session for High performers in LIP program',
            'initiative_id' => $Initiative19->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity119 = MainActivity::updateOrCreate([
            'title' => 'Graduate 6th and 7th rounds of LIP trainees',
            'initiative_id' => $Initiative19->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity120 = MainActivity::updateOrCreate([
            'title' => 'Revise LIP training manual as per the high impact leadership training manual',
            'initiative_id' => $Initiative19->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity121 = MainActivity::updateOrCreate([
            'title' => 'Select LIP trainees for the 8th round  and conduct  the 8th round of training',
            'initiative_id' => $Initiative19->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity122 = MainActivity::updateOrCreate([
            'title' => 'Establish networking event for LIP trainees',
            'initiative_id' => $Initiative19->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $Initiative20 = Initiative::updateOrCreate([
            'title' => 'Improve  planning, monitoring and evaluation practices of the HSIQI LEO',
            'objective_id' => $objective2->id,
        ]);

        $mainActivity123 = MainActivity::updateOrCreate([
            'title' => 'Prepare and timely submit annual, biannual and quarter report of the lead executive office to SA EO',
            'initiative_id' => $Initiative20->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity124 = MainActivity::updateOrCreate([
            'title' => 'Conduct regularly  LEO\'s , Transformation and desk forums',
            'initiative_id' => $Initiative20->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity125 = MainActivity::updateOrCreate([
            'title' => 'Ensure good governance',
            'initiative_id' => $Initiative20->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity126 = MainActivity::updateOrCreate([
            'title' => 'Enhance civil service pragmatism and institutionalization',
            'initiative_id' => $Initiative20->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $Initiative21 = Initiative::updateOrCreate([
            'title' => 'Improve budget utilization',
            'objective_id' => $objective2->id,
        ]);

        $mainActivity127 = MainActivity::updateOrCreate([
            'title' => 'Timely transfer allocated budget',
            'initiative_id' => $Initiative21->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);

        $mainActivity128 = MainActivity::updateOrCreate([
            'title' => 'Monitor and support budget utilization and liquidation',
            'initiative_id' => $Initiative21->id,
            'target' => 0,
            'type' => 'Main Activity',
            'measuring_unit_id' => MeasuringUnit::where('name', 'Number')->first()->id,
            'weight' => 0,
        ]);
    }
}
