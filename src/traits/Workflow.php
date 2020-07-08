<?php
/**
 * 十贰进销存系统
 * ==========================================================================
 * @link      http://erp.chaolizi.cn/
 * @license   http://erp.chaolizi.cn/license.html License
 * @Desc      工作流程
 * ==========================================================================
 * @author    张大宝的程序人生 <1107842285@qq.com>
 */
declare(strict_types=1);

namespace dashingUnique\library\traits;

use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\SupportStrategy\InstanceOfSupportStrategy;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow as BaseWorkflow;

trait Workflow
{
    /**
     * @var bool 是否开启工作流 false不开启， true开启
     */
    protected $isInitWorkflow = false;

    /**
     * @var string 当前节点的标签
     */
    private $currentPlace = 'state';

    /**
     * @var array 节点信息
     */
    protected $places;

    /**
     * @var MethodMarkingStore 方法标记
     */
    protected $markingStore;

    /**
     * @var Registry
     */
    protected $registry;

    /**
     * @var DefinitionBuilder 工作流创建器
     */
    protected $builder;

    /**
     * @var BaseWorkflow 工作流
     */
    protected $workflow;

    /**
     * @var array 过渡信息
     */
    protected $transitions;

    /**
     * 工作流创建器
     * @param DefinitionBuilder $builder
     * @return $this
     */
    public function setBuilder(DefinitionBuilder $builder)
    {
        $this->builder = $builder;
        return $this;
    }

    /**
     * @return DefinitionBuilder 获取工作流构建器
     */
    public function getBuilder()
    {
        if (is_null($this->builder)) {
            $this->builder = new DefinitionBuilder();
        }
        return $this->builder;
    }

    /**
     * 添加节点信息
     * @return $this
     */
    public function addPlaces()
    {
        if (!empty($this->places)) {
            $this->builder->addPlaces($this->places);
        }
        return $this;
    }

    /**
     * 添加过渡节点信息
     * @return $this
     */
    public function addTransitions()
    {
        if (!empty($this->transitions)) {
            foreach ($this->transitions as $name => $value) {
                list($from, $to) = $value;
                $transition = new Transition($name, $from, $to);
                $this->getBuilder()->addTransition($transition);
            }
        }
        return $this;
    }

    /**
     * 设置标记储存
     * @param MethodMarkingStore $markingStore
     * @return $this
     */
    public function setMarkingStore(MethodMarkingStore $markingStore)
    {
        $this->markingStore = $markingStore;
        return $this;
    }

    /**
     * 获取标记储存
     * @return MethodMarkingStore
     */
    public function getMarkingStore()
    {
        if (is_null($this->markingStore)) {
            $this->markingStore = new MethodMarkingStore(true, $this->currentPlace);
        }
        return $this->markingStore;
    }

    /**
     * 设置工作流
     * @param BaseWorkflow $workflow
     * @return $this
     */
    public function setWorkflow(BaseWorkflow $workflow)
    {
        $this->workflow = $workflow;
        return $this;
    }

    /**
     * 获取工作流对象
     * @return BaseWorkflow
     */
    public function getWorkflow()
    {
        if (is_null($this->workflow)) {
            $this->workflow = new BaseWorkflow($this->getBuilder()->build(), $this->getMarkingStore());
        }
        return $this->workflow;
    }

    /**
     * 工作流注册机
     * @return Registry
     */
    public function getRegistry()
    {
        if (empty($this->registry)) {
            $this->registry = new Registry();
        }
        return $this->registry;
    }

    /**
     * 初始化工作流
     */
    public function initWorkflow()
    {
        $this->addPlaces();
        $this->addTransitions();
        $this->setWorkflow(new BaseWorkflow($this->getBuilder()->build(), $this->getMarkingStore()));
        $this->getRegistry()->addWorkflow($this->getWorkflow(), new InstanceOfSupportStrategy(self::class));
    }
}