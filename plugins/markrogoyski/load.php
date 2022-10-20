<?php //*
if(!defined('D_markrogoyski')){
    define('D_markrogoyski',true);
    require __DIR__.'/math-php/src/Exception/MathException.php';
    require __DIR__.'/math-php/src/Exception/MatrixException.php';
    require __DIR__.'/math-php/src/Exception/BadDataException.php';
    require __DIR__.'/math-php/src/Exception/BadParameterException.php';
    require __DIR__.'/math-php/src/Exception/FunctionFailedToConvergeException.php';
    require __DIR__.'/math-php/src/Exception/IncorrectTypeException.php';
    require __DIR__.'/math-php/src/Exception/OutOfBoundsException.php';
    require __DIR__.'/math-php/src/Exception/SingularMatrixException.php';
    require __DIR__.'/math-php/src/Exception/VectorException.php';

    require __DIR__.'/math-php/src/Algebra.php';
    require __DIR__.'/math-php/src/Arithmetic.php';
    require __DIR__.'/math-php/src/Finance.php';

    require __DIR__.'/math-php/src/Functions/Special.php';

    require __DIR__.'/math-php/src/Number/ObjectArithmetic.php';
    require __DIR__.'/math-php/src/Number/ArbitraryInteger.php';
    require __DIR__.'/math-php/src/Number/Rational.php';
    require __DIR__.'/math-php/src/Number/Complex.php';

    require __DIR__.'/math-php/src/Functions/ArbitraryInteger.php';
    require __DIR__.'/math-php/src/Functions/Arithmetic.php';
    require __DIR__.'/math-php/src/Functions/BaseEncoderDecoder.php';
    require __DIR__.'/math-php/src/Functions/Bitwise.php';
    require __DIR__.'/math-php/src/Functions/Map/Multi.php';
    require __DIR__.'/math-php/src/Functions/Map/Single.php';
    require __DIR__.'/math-php/src/Functions/Piecewise.php';
    require __DIR__.'/math-php/src/Functions/Polynomial.php';
    require __DIR__.'/math-php/src/Functions/Support.php';

    require __DIR__.'/math-php/src/InformationTheory/Entropy.php';
    require __DIR__.'/math-php/src/NumberTheory/Integer.php';

    require __DIR__.'/math-php/src/NumericalAnalysis/Interpolation/Interpolation.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/Interpolation/ClampedCubicSpline.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/Interpolation/LagrangePolynomial.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/Interpolation/NaturalCubicSpline.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/Interpolation/NevillesMethod.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/Interpolation/NewtonPolynomialForward.php';
    
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalDifferentiation/NumericalDifferentiation.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalDifferentiation/FivePointFormula.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalDifferentiation/SecondDerivativeMidpointFormula.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalDifferentiation/ThreePointFormula.php';

    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalIntegration/NumericalIntegration.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalIntegration/BoolesRule.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalIntegration/MidpointRule.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalIntegration/RectangleMethod.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalIntegration/SimpsonsRule.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalIntegration/SimpsonsThreeEighthsRule.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalIntegration/TrapezoidalRule.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/NumericalIntegration/Validation.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/RootFinding/BisectionMethod.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/RootFinding/FixedPointIteration.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/RootFinding/NewtonsMethod.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/RootFinding/SecantMethod.php';
    require __DIR__.'/math-php/src/NumericalAnalysis/RootFinding/Validation.php';

    require __DIR__.'/math-php/src/Probability/Combinatorics.php';

    require __DIR__.'/math-php/src/Probability/Distribution/Distribution.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/ContinuousDistribution.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Continuous.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Beta.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Cauchy.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/ChiSquared.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/DiracDelta.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Exponential.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/F.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Gamma.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Laplace.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/LogLogistic.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/LogNormal.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Logistic.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/NoncentralT.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Normal.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Pareto.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/StandardNormal.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/StudentT.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Uniform.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Continuous/Weibull.php';

    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/Discrete.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/Bernoulli.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/Binomial.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/Categorical.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/Geometric.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/Hypergeometric.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/NegativeBinomial.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/Pascal.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/Poisson.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/ShiftedGeometric.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Discrete/Uniform.php';

    require __DIR__.'/math-php/src/Probability/Distribution/Multivariate/Dirichlet.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Multivariate/Hypergeometric.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Multivariate/Multinomial.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Multivariate/Normal.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Table/ChiSquared.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Table/StandardNormal.php';
    require __DIR__.'/math-php/src/Probability/Distribution/Table/TDistribution.php';
    require __DIR__.'/math-php/src/SampleData/Iris.php';
    require __DIR__.'/math-php/src/SampleData/MtCars.php';
    require __DIR__.'/math-php/src/SampleData/PlantGrowth.php';
    require __DIR__.'/math-php/src/SampleData/ToothGrowth.php';
    require __DIR__.'/math-php/src/SampleData/UsArrests.php';
    require __DIR__.'/math-php/src/Sequence/Advanced.php';
    require __DIR__.'/math-php/src/Sequence/Basic.php';
    require __DIR__.'/math-php/src/Sequence/NonInteger.php';

    require __DIR__.'/math-php/src/SetTheory/Set.php';
    require __DIR__.'/math-php/src/SetTheory/ImmutableSet.php';

    require __DIR__.'/math-php/src/Statistics/ANOVA.php';
    require __DIR__.'/math-php/src/Statistics/Average.php';
    require __DIR__.'/math-php/src/Statistics/Circular.php';
    require __DIR__.'/math-php/src/Statistics/Correlation.php';
    require __DIR__.'/math-php/src/Statistics/Descriptive.php';
    require __DIR__.'/math-php/src/Statistics/Distance.php';
    require __DIR__.'/math-php/src/Statistics/Distribution.php';
    require __DIR__.'/math-php/src/Statistics/EffectSize.php';
    require __DIR__.'/math-php/src/Statistics/Experiment.php';
    require __DIR__.'/math-php/src/Statistics/KernelDensityEstimation.php';
    require __DIR__.'/math-php/src/Statistics/Multivariate/PCA.php';
    require __DIR__.'/math-php/src/Statistics/Outlier.php';
    require __DIR__.'/math-php/src/Statistics/RandomVariable.php';

    require __DIR__.'/math-php/src/LinearAlgebra/Matrix.php';
    require __DIR__.'/math-php/src/LinearAlgebra/MatrixCatalog.php';
    require __DIR__.'/math-php/src/LinearAlgebra/MatrixFactory.php';
    require __DIR__.'/math-php/src/LinearAlgebra/SquareMatrix.php';
    require __DIR__.'/math-php/src/LinearAlgebra/ObjectSquareMatrix.php';
    require __DIR__.'/math-php/src/LinearAlgebra/ColumnVector.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Decomposition/Decomposition.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Decomposition/Cholesky.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Decomposition/Crout.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Decomposition/LU.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Decomposition/QR.php';
    require __DIR__.'/math-php/src/LinearAlgebra/DiagonalMatrix.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Eigenvalue.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Eigenvector.php';
    require __DIR__.'/math-php/src/LinearAlgebra/FunctionMatrix.php';
    require __DIR__.'/math-php/src/LinearAlgebra/FunctionSquareMatrix.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Householder.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Reduction/ReducedRowEchelonForm.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Reduction/RowEchelonForm.php';
    require __DIR__.'/math-php/src/LinearAlgebra/RowVector.php';
    require __DIR__.'/math-php/src/LinearAlgebra/Vector.php';

    require __DIR__.'/math-php/src/Statistics/Regression/Methods/LeastSquares.php';
    require __DIR__.'/math-php/src/Statistics/Regression/Methods/WeightedLeastSquares.php';
    require __DIR__.'/math-php/src/Statistics/Regression/Models/MichaelisMenten.php';

    require __DIR__.'/math-php/src/Statistics/Regression/Regression.php';
    require __DIR__.'/math-php/src/Statistics/Regression/ParametricRegression.php';
    require __DIR__.'/math-php/src/Statistics/Regression/NonParametricRegression.php';
    require __DIR__.'/math-php/src/Statistics/Regression/HanesWoolf.php';
    require __DIR__.'/math-php/src/Statistics/Regression/LOESS.php';

    require __DIR__.'/math-php/src/Statistics/Regression/Models/LinearModel.php';
    require __DIR__.'/math-php/src/Statistics/Regression/Models/PowerModel.php';
    require __DIR__.'/math-php/src/Statistics/Regression/LinearThroughPoint.php';
    require __DIR__.'/math-php/src/Statistics/Regression/LineweaverBurk.php';

    require __DIR__.'/math-php/src/Statistics/Regression/Linear.php';
    require __DIR__.'/math-php/src/Statistics/Regression/PowerLaw.php';
    require __DIR__.'/math-php/src/Statistics/Regression/TheilSen.php';
    require __DIR__.'/math-php/src/Statistics/Regression/WeightedLinear.php';
    require __DIR__.'/math-php/src/Statistics/Significance.php';
    require __DIR__.'/math-php/src/Trigonometry.php';
}
/*/
$dir=__DIR__.'/';
//require __DIR__.'/';
function scand($dir,&$res){
    $d=scandir($dir);
    foreach($d as $k => $v)if($v!='..'&&$v!='.'&&$v!='load.php'){
        if(is_dir($dir.$v)){
            scand($dir.$v.'/',$res);
        }elseif(strpos($dir,'tes')===false){
            $a=explode('.',$v);
            $a=end($a);
            if($a=='php')
            $res[]=$dir.$v;
        }
    }
}
$res=array();
scand($dir,$res);
foreach($res as $k => $v)
    echo 'require __DIR__.\''.str_replace(__DIR__,'',$v).'\';'.chr(10);//*/
?>